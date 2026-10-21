<?php
class Csrf {
    public static function token(): string {
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (empty($_SESSION['_csrf'])) $_SESSION['_csrf'] = bin2hex(random_bytes(32));
        return $_SESSION['_csrf'];
    }
    public static function check(): void {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $t = $_POST['_csrf'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
            if (!hash_equals($_SESSION['_csrf'] ?? '', $t)) {
                http_response_code(419); die('CSRF inválido.');
            }
        }
    }
    public static function field(): string {
        return '<input type="hidden" name="_csrf" value="' . self::token() . '">';
    }
}