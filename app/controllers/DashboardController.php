<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../config/database.php';

class DashboardController extends Controller {
    public function index() {
        Auth::require();
        $pdo = Database::pdo();
        $today = date('Y-m-d');
        $stats = [
            'total'      => $pdo->query("SELECT COUNT(*) FROM deliveries WHERE DATE(created_at)='$today'")->fetchColumn(),
            'done'       => $pdo->query("SELECT COUNT(*) FROM deliveries WHERE status='concluida'")->fetchColumn(),
            'progress'   => $pdo->query("SELECT COUNT(*) FROM deliveries WHERE status='em_andamento'")->fetchColumn(),
            'late'       => $pdo->query("SELECT COUNT(*) FROM deliveries WHERE status='atrasada'")->fetchColumn(),
            'vehicles'   => $pdo->query("SELECT COUNT(*) FROM vehicles WHERE status='disponivel'")->fetchColumn(),
        ];
        $totalDone = $pdo->query("SELECT COUNT(*) FROM deliveries")->fetchColumn() ?: 1;
        $stats['ontime'] = round(($stats['done'] / $totalDone) * 100);

        $recent = $pdo->query("SELECT d.*, dr.name AS driver_name FROM deliveries d
            LEFT JOIN drivers dr ON dr.id=d.driver_id ORDER BY d.created_at DESC LIMIT 8")->fetchAll();

        $byDay = $pdo->query("SELECT DATE(created_at) d, COUNT(*) c FROM deliveries
            WHERE created_at >= NOW() - INTERVAL 7 DAY GROUP BY DATE(created_at)")->fetchAll();

        $byStatus = $pdo->query("SELECT status, COUNT(*) c FROM deliveries GROUP BY status")->fetchAll();

        $alerts = $pdo->query("SELECT * FROM alerts WHERE read_flag=0 ORDER BY created_at DESC LIMIT 5")->fetchAll();

        $this->view('dashboard/index', compact('stats','recent','byDay','byStatus','alerts'));
    }
}