<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../config/database.php';

class DeliveryController extends Controller {
    public function index() {
        Auth::require();
        $pdo = Database::pdo();
        $filterStatus = $_GET['status'] ?? '';
        $search = trim($_GET['q'] ?? '');
        $sql = "SELECT d.*, dr.name AS driver_name, v.plate FROM deliveries d
                LEFT JOIN drivers dr ON dr.id=d.driver_id
                LEFT JOIN vehicles v ON v.id=d.vehicle_id WHERE 1=1";
        $params = [];
        if ($filterStatus) { $sql .= " AND d.status=?"; $params[] = $filterStatus; }
        if ($search) { $sql .= " AND (d.code LIKE ? OR d.recipient LIKE ?)"; $params[] = "%$search%"; $params[] = "%$search%"; }
        $sql .= " ORDER BY d.created_at DESC LIMIT 100";
        $stmt = $pdo->prepare($sql); $stmt->execute($params);
        $deliveries = $stmt->fetchAll();

        $drivers  = $pdo->query("SELECT id,name FROM drivers WHERE available=1")->fetchAll();
        $vehicles = $pdo->query("SELECT id,plate,model FROM vehicles WHERE status<>'manutencao'")->fetchAll();
        $this->view('deliveries/index', compact('deliveries','drivers','vehicles','filterStatus','search'));
    }

    public function store() {
        Auth::requireRole(['admin','gestor','despachante']);
        $pdo = Database::pdo();
        $code = 'DEL-' . strtoupper(bin2hex(random_bytes(3)));
        $pdo->prepare("INSERT INTO deliveries (code,recipient,address,driver_id,vehicle_id,deadline,priority,status)
                       VALUES (?,?,?,?,?,?,?, 'pendente')")
            ->execute([
                $code,
                trim($_POST['recipient'] ?? ''),
                trim($_POST['address'] ?? ''),
                $_POST['driver_id'] ?: null,
                $_POST['vehicle_id'] ?: null,
                $_POST['deadline'] ?: null,
                $_POST['priority'] ?? 'media',
            ]);
        $this->redirect('/deliveries');
    }

    public function update() {
        Auth::requireRole(['admin','gestor','despachante','motorista']);
        $pdo = Database::pdo();
        $id = (int)($_POST['id'] ?? 0);
        $status = $_POST['status'] ?? 'pendente';
        $allowed = ['pendente','em_andamento','concluida','atrasada','cancelada'];
        if (!in_array($status, $allowed, true) || !$id) { $this->redirect('/deliveries'); }
        $pdo->prepare('UPDATE deliveries SET status=? WHERE id=?')->execute([$status, $id]);
        $pdo->prepare('INSERT INTO delivery_status_history (delivery_id,status,changed_by) VALUES (?,?,?)')
            ->execute([$id, $status, Auth::user()['id']]);
        $this->redirect('/deliveries');
    }

    public function delete() {
        Auth::requireRole(['admin','gestor']);
        Database::pdo()->prepare('DELETE FROM deliveries WHERE id=?')->execute([(int)($_POST['id'] ?? 0)]);
        $this->redirect('/deliveries');
    }

    public function apiList() {
        Auth::require();
        $rows = Database::pdo()->query("SELECT id,code,recipient,status,address,lat,lng FROM deliveries LIMIT 200")->fetchAll();
        $this->json($rows);
    }
}