<?php
require_once __DIR__ . '/../config/database.php';

class Auth {
    public static function start(): void {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
    }
    public static function login(string $email, string $pass): bool {
        self::start();
        $stmt = Database::pdo()->prepare(
            'SELECT u.*, p.name AS profile FROM users u JOIN profiles p ON p.id=u.profile_id WHERE u.email=? AND u.active=1 LIMIT 1');
        $stmt->execute([$email]);
        $u = $stmt->fetch();
        if ($u && password_verify($pass, $u['password_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id' => $u['id'], 'name' => $u['name'],
                'email' => $u['email'], 'profile' => $u['profile'],
            ];
            return true;
        }
        return false;
    }
    public static function user() { self::start(); return $_SESSION['user'] ?? null; }
    public static function check(): bool { return self::user() !== null; }
    public static function logout(): void { self::start(); session_destroy(); }
    public static function require(): void {
        if (!self::check()) { header('Location: ' . APP_URL . '/login'); exit; }
    }
    public static function requireRole(array $roles): void {
        self::require();
        if (!in_array(self::user()['profile'], $roles, true)) {
            http_response_code(403); die('Acesso negado.');
        }
    }
}