<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../config/database.php';

class ProofController extends Controller {
    public function index() {
        Auth::require();
        $pdo = Database::pdo();
        $proofs = $pdo->query("SELECT p.*, d.code, d.recipient FROM proofs p JOIN deliveries d ON d.id=p.delivery_id ORDER BY p.delivered_at DESC LIMIT 100")->fetchAll();
        $deliveries = $pdo->query("SELECT id,code,recipient FROM deliveries WHERE status<>'cancelada'")->fetchAll();
        $this->view('proofs/index', compact('proofs','deliveries'));
    }
    public function store() {
        Auth::requireRole(['admin','gestor','despachante','motorista']);
        $id = (int)($_POST['delivery_id'] ?? 0);
        if (!$id) $this->redirect('/proofs');
        $evidence = null;
        if (!empty($_FILES['evidence']['tmp_name']) && is_uploaded_file($_FILES['evidence']['tmp_name'])) {
            $ext = strtolower(pathinfo($_FILES['evidence']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['jpg','jpeg','png','webp'])) {
                $dir = __DIR__ . '/../../public/uploads/';
                if (!is_dir($dir)) mkdir($dir, 0775, true);
                $fname = 'proof_' . uniqid() . '.' . $ext;
                move_uploaded_file($_FILES['evidence']['tmp_name'], $dir . $fname);
                $evidence = 'uploads/' . $fname;
            }
        }
        Database::pdo()->prepare("INSERT INTO proofs (delivery_id,delivered_at,lat,lng,evidence_path,notes) VALUES (?,?,?,?,?,?)")
            ->execute([
                $id, $_POST['delivered_at'] ?: date('Y-m-d H:i:s'),
                $_POST['lat'] ?: null, $_POST['lng'] ?: null,
                $evidence, trim($_POST['notes'] ?? '')
            ]);
        Database::pdo()->prepare("UPDATE deliveries SET status='concluida' WHERE id=?")->execute([$id]);
        $this->redirect('/proofs');
    }
}