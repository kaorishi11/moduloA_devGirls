<?php
require_once __DIR__ . '/Csrf.php';
require_once __DIR__ . '/Auth.php';

class Controller {
    protected function view(string $file, array $data = [], bool $layout = true): void {
        extract($data);
        $viewFile = __DIR__ . '/../views/' . $file . '.php';
        if (!file_exists($viewFile)) { http_response_code(500); die("View $file não encontrada."); }
        if ($layout) {
            require __DIR__ . '/../views/layouts/main.php';
        } else {
            require $viewFile;
        }
    }
    protected function redirect(string $path): void {
        header('Location: ' . APP_URL . $path); exit;
    }
    protected function json($data, int $code = 200): void {
        http_response_code($code);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data); exit;
    }
}