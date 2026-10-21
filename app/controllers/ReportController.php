<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../config/database.php';

class ReportController extends Controller {
    public function index() {
        Auth::requireRole(['admin','gestor','despachante']);
        $pdo = Database::pdo();
        $byStatus = $pdo->query("SELECT status, COUNT(*) c FROM deliveries GROUP BY status")->fetchAll();
        $byRegion = $pdo->query("SELECT SUBSTRING_INDEX(address,'-',-1) region, COUNT(*) c FROM deliveries GROUP BY region ORDER BY c DESC LIMIT 8")->fetchAll();
        $km = $pdo->query("SELECT SUM(autonomy_km) total FROM vehicles")->fetchColumn() ?: 0;
        $cost = $pdo->query("SELECT COUNT(*) * 8.50 AS total FROM deliveries WHERE status='concluida'")->fetchColumn() ?: 0;
        $ontime = $pdo->query("SELECT (SELECT COUNT(*) FROM deliveries WHERE status='concluida') / GREATEST((SELECT COUNT(*) FROM deliveries),1) * 100")->fetchColumn();
        $this->view('reports/index', compact('byStatus','byRegion','km','cost','ontime'));
    }

    public function export() {
        Auth::requireRole(['admin','gestor']);
        $format = $_GET['format'] ?? 'csv';
        $rows = Database::pdo()->query("SELECT code,recipient,address,status,priority,deadline FROM deliveries ORDER BY created_at DESC")->fetchAll();
        if ($format === 'csv') {
            header('Content-Type: text/csv; charset=utf-8');
            header('Content-Disposition: attachment; filename="entregas.csv"');
            $out = fopen('php://output', 'w');
            fputcsv($out, ['Código','Destinatário','Endereço','Status','Prioridade','Prazo'], ';');
            foreach ($rows as $r) fputcsv($out, array_values($r), ';');
            fclose($out); exit;
        }
        // PDF simplificado (HTML para impressão)
        header('Content-Type: text/html; charset=utf-8');
        echo '<h2>Relatório de Entregas — SENN AI-X</h2><table border="1" cellpadding="6" style="border-collapse:collapse;font-family:sans-serif"><tr><th>Código</th><th>Destinatário</th><th>Endereço</th><th>Status</th><th>Prioridade</th><th>Prazo</th></tr>';
        foreach ($rows as $r) {
            echo '<tr>';
            foreach ($r as $v) echo '<td>' . htmlspecialchars((string)$v) . '</td>';
            echo '</tr>';
        }
        echo '</table><script>window.print()</script>';
        exit;
    }
}