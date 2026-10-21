<?php
class Router {
    private array $routes = [];
    public function get(string $p, callable $h): void { $this->routes['GET'][$p] = $h; }
    public function post(string $p, callable $h): void { $this->routes['POST'][$p] = $h; }
    public function dispatch(string $method, string $uri): void {
        $uri = '/' . trim(parse_url($uri, PHP_URL_PATH), '/');
        $uri = preg_replace('#^/index\.php#', '', $uri) ?: '/';
        foreach ($this->routes[$method] ?? [] as $pattern => $handler) {
            $regex = '#^' . preg_replace('#\{[a-z]+\}#', '([^/]+)', $pattern) . '$#';
            if (preg_match($regex, $uri, $m)) {
                array_shift($m);
                call_user_func_array($handler, $m);
                return;
            }
        }
        http_response_code(404);
        echo 'Página não encontrada.';
    }
}