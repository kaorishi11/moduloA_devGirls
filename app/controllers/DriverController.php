<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../config/database.php';

class DriverController extends Controller {
    public function index() {
        Auth::requireRole(['admin','gestor','despachante']);
        $pdo = Database::pdo();
        $drivers = $pdo->query("SELECT d.*, v.plate FROM drivers d LEFT JOIN vehicles v ON v.id=d.vehicle_id ORDER BY d.name")->fetchAll();
        $vehicles = $pdo->query("SELECT id,plate FROM vehicles")->fetchAll();
        $this->view('drivers/index', compact('drivers','vehicles'));
    }
    public function store() {
        Auth::requireRole(['admin','gestor']);
        Database::pdo()->prepare("INSERT INTO drivers (name,cnh,category,cnh_valid_until,contact,available,vehicle_id)
            VALUES (?,?,?,?,?,?,?)")->execute([
            trim($_POST['name'] ?? ''),
            strtoupper(trim($_POST['cnh'] ?? '')),
            $_POST['category'] ?? 'B',
            $_POST['cnh_valid_until'] ?: null,
            trim($_POST['contact'] ?? ''),
            isset($_POST['available']) ? 1 : 0,
            $_POST['vehicle_id'] ?: null,
        ]);
        $this->redirect('/drivers');
    }
    public function update() {
        Auth::requireRole(['admin','gestor']);
        Database::pdo()->prepare("UPDATE drivers SET name=?,category=?,cnh_valid_until=?,contact=?,available=?,vehicle_id=? WHERE id=?")
            ->execute([
                trim($_POST['name'] ?? ''),
                $_POST['category'] ?? 'B',
                $_POST['cnh_valid_until'] ?: null,
                trim($_POST['contact'] ?? ''),
                isset($_POST['available']) ? 1 : 0,
                $_POST['vehicle_id'] ?: null,
                (int)($_POST['id'] ?? 0),
            ]);
        $this->redirect('/drivers');
    }
    public function delete() {
        Auth::requireRole(['admin']);
        Database::pdo()->prepare("DELETE FROM drivers WHERE id=?")->execute([(int)($_POST['id'] ?? 0)]);
        $this->redirect('/drivers');
    }
}