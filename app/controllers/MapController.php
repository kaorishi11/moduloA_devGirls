<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../config/database.php';

class MapController extends Controller {
    public function index() {
        Auth::require();
        $this->view('map/index', ['googleKey' => env('GOOGLE_MAPS_API_KEY','')]);
    }
    public function apiData() {
        Auth::require();
        $pdo = Database::pdo();
        $deliveries = $pdo->query("SELECT id,code,recipient,address,lat,lng,status FROM deliveries WHERE lat IS NOT NULL AND lng IS NOT NULL")->fetchAll();
        $vehicles = $pdo->query("SELECT v.plate,v.model,v.status,dr.name AS driver FROM vehicles v LEFT JOIN drivers dr ON dr.vehicle_id=v.id")->fetchAll();
        $this->json(['deliveries' => $deliveries, 'vehicles' => $vehicles]);
    }
}