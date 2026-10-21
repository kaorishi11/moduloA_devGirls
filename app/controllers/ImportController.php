<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../config/database.php';

class ImportController extends Controller {
    public function index() {
        Auth::requireRole(['admin','gestor','despachante']);
        $this->view('import/index');
    }
    public function validate() {
        Auth::requireRole(['admin','gestor','despachante']);
        if (empty($_FILES['csv']['tmp_name'])) $this->redirect('/import');
        $rows = [];
        $errors = [];
        $fh = fopen($_FILES['csv']['tmp_name'], 'r');
        $header = fgetcsv($fh, 0, ';');
        $i = 1;
        while (($line = fgetcsv($fh, 0, ';')) !== false) {
            $i++;
            if (count($line) < 3) { $errors[] = "Linha $i: colunas insuficientes"; continue; }
            [$code,$recipient,$address,$deadline,$priority] = array_pad($line, 5, '');
            if (!$recipient || !$address) { $errors[] = "Linha $i: destinatário/endereço obrigatório"; continue; }
            $rows[] = compact('code','recipient','address','deadline','priority');
        }
        fclose($fh);
        $_SESSION['import_rows'] = $rows;
        $this->view('import/index', compact('rows','errors'));
    }
    public function confirm() {
        Auth::requireRole(['admin','gestor','despachante']);
        $rows = $_SESSION['import_rows'] ?? [];
        $pdo = Database::pdo();
        $stmt = $pdo->prepare("INSERT INTO deliveries (code,recipient,address,deadline,priority,status) VALUES (?,?,?,?,?, 'pendente')");
        $ok = 0;
        foreach ($rows as $r) {
            $code = $r['code'] ?: 'DEL-' . strtoupper(bin2hex(random_bytes(3)));
            try { $stmt->execute([$code, $r['recipient'], $r['address'], $r['deadline'] ?: null, $r['priority'] ?: 'media']); $ok++; }
            catch (PDOException $e) {}
        }
        unset($_SESSION['import_rows']);
        $_SESSION['import_flash'] = "Importadas $ok entregas.";
        $this->redirect('/import');
    }
}