<?php
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../config/database.php';

class AuthController extends Controller {
    public function loginForm() { $this->view('auth/login', ['title' => 'Entrar'], false); }

    public function login() {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $pass  = $_POST['password'] ?? '';
        if (!$email || !$pass) return $this->view('auth/login', ['error' => 'Dados inválidos.'], false);
        if (Auth::login($email, $pass)) $this->redirect('/dashboard');
        $this->view('auth/login', ['error' => 'Credenciais inválidas.'], false);
    }

    public function registerForm() { $this->view('auth/register', ['title' => 'Cadastro'], false); }

    public function register() {
        $name = trim($_POST['name'] ?? '');
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        $pass = $_POST['password'] ?? '';
        if (!$name || !$email || strlen($pass) < 6)
            return $this->view('auth/register', ['error' => 'Preencha todos os campos (senha ≥ 6).'], false);
        $pdo = Database::pdo();
        $exists = $pdo->prepare('SELECT id FROM users WHERE email=?');
        $exists->execute([$email]);
        if ($exists->fetch()) return $this->view('auth/register', ['error' => 'E-mail já cadastrado.'], false);
        $pdo->prepare('INSERT INTO users (name,email,password_hash,profile_id) VALUES (?,?,?,3)')
            ->execute([$name, $email, password_hash($pass, PASSWORD_DEFAULT)]);
        $this->redirect('/login');
    }

    public function logout() { Auth::logout(); $this->redirect('/login'); }
}