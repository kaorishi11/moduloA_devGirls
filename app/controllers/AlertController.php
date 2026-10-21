<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../config/database.php';

class AlertController extends Controller {
    public function index() {
        Auth::require();
        $alerts = Database::pdo()->query("SELECT * FROM alerts ORDER BY created_at DESC LIMIT 100")->fetchAll();
        $this->view('alerts/index', compact('alerts'));
    }
    public function markRead() {
        Auth::require();
        Database::pdo()->prepare("UPDATE alerts SET read_flag=1 WHERE id=?")->execute([(int)($_POST['id'] ?? 0)]);
        $this->redirect('/alerts');
    }
}