<?php
function env($key, $default = null) {
    static $vars = null;
    if ($vars === null) {
        $vars = [];
        $path = __DIR__ . '/../../.env';
        if (file_exists($path)) {
            foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                if (str_starts_with(trim($line), '#')) continue;
                [$k, $v] = array_pad(explode('=', $line, 2), 2, '');
                $vars[trim($k)] = trim($v, " \t\"'");
            }
        }
    }
    return $vars[$key] ?? $default;
}
define('APP_NAME', env('APP_NAME', 'SENN AI-X'));
define('APP_URL', env('APP_URL', '/'));
define('APP_ENV', env('APP_ENV', 'production'));
define('APP_KEY', env('APP_KEY', 'insecure'));