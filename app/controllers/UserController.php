<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../config/database.php';

class UserController extends Controller {
    public function index() {
        Auth::requireRole(['admin']);
        $pdo = Database::pdo();
        $users = $pdo->query("SELECT u.id,u.name,u.email,u.active,p.name profile FROM users u JOIN profiles p ON p.id=u.profile_id ORDER BY u.id")->fetchAll();
        $profiles = $pdo->query("SELECT * FROM profiles")->fetchAll();
        $this->view('users/index', compact('users','profiles'));
    }
        public function store() {
        Auth::requireRole(['admin']);
        $name = trim($_POST['name'] ?? '');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $pass = $_POST['password'] ?? '';
        $profile = (int)($_POST['profile_id'] ?? 3);
        if (!$name || !$email || strlen($pass) < 6) { $this->redirect('/users'); }
        try {
            Database::pdo()->prepare("INSERT INTO users (name,email,password_hash,profile_id) VALUES (?,?,?,?)")
                ->execute([$name, $email, password_hash($pass, PASSWORD_DEFAULT), $profile]);
        } catch (PDOException $e) { /* duplicado */ }
        $this->redirect('/users');
    }
}