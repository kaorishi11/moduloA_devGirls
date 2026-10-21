<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../config/database.php';

class VehicleController extends Controller {
    public function index() {
        Auth::requireRole(['admin','gestor','despachante']);
        $vehicles = Database::pdo()->query("SELECT * FROM vehicles ORDER BY created_at DESC")->fetchAll();
        $this->view('vehicles/index', compact('vehicles'));
    }
    public function store() {
        Auth::requireRole(['admin','gestor']);
        Database::pdo()->prepare("INSERT INTO vehicles (plate,model,capacity_kg,volume_m3,autonomy_km,status)
            VALUES (?,?,?,?,?,?)")->execute([
            strtoupper(trim($_POST['plate'] ?? '')),
            trim($_POST['model'] ?? ''),
            (float)($_POST['capacity_kg'] ?? 0),
            (float)($_POST['volume_m3'] ?? 0),
            (int)($_POST['autonomy_km'] ?? 0),
            $_POST['status'] ?? 'disponivel',
        ]);
        $this->redirect('/vehicles');
    }
    public function update() {
        Auth::requireRole(['admin','gestor']);
        Database::pdo()->prepare("UPDATE vehicles SET model=?,capacity_kg=?,volume_m3=?,autonomy_km=?,status=? WHERE id=?")
            ->execute([
                trim($_POST['model'] ?? ''),
                (float)($_POST['capacity_kg'] ?? 0),
                (float)($_POST['volume_m3'] ?? 0),
                (int)($_POST['autonomy_km'] ?? 0),
                $_POST['status'] ?? 'disponivel',
                (int)($_POST['id'] ?? 0),
            ]);
        $this->redirect('/vehicles');
    }
    public function delete() {
        Auth::requireRole(['admin']);
        Database::pdo()->prepare("DELETE FROM vehicles WHERE id=?")->execute([(int)($_POST['id'] ?? 0)]);
        $this->redirect('/vehicles');
    }
}