<?php
declare(strict_types=1);

// Carga variables desde .env sin dependencias externas.
$envFile = dirname(__DIR__, 2) . '/.env';
if (is_file($envFile)) {
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value, " \t\n\r\0\x0B\"");
    }
}

spl_autoload_register(function (string $class): void {
    $prefix = 'App\\';
    if (!str_starts_with($class, $prefix)) return;
    $relative = substr($class, strlen($prefix));
    $path = __DIR__ . '/../' . str_replace('\\', '/', $relative) . '.php';
    if (is_file($path)) require_once $path;
});

$origin = $_ENV['CORS_ORIGIN'] ?? 'http://localhost:5173';
header('Access-Control-Allow-Origin: ' . $origin);
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Content-Type: application/json; charset=utf-8');
if (($_SERVER['REQUEST_METHOD'] ?? '') === 'OPTIONS') { http_response_code(204); exit; }

set_exception_handler(function (Throwable $e): void {
    $debug = filter_var($_ENV['APP_DEBUG'] ?? 'false', FILTER_VALIDATE_BOOLEAN);
    error_log((string)$e);
    $message = 'Error interno del servidor.';
    $status = 500;
    if ($e instanceof PDOException && $e->getCode() === '23000') {
        $message = 'No se puede completar la operación porque existe una relación o dato duplicado.';
        $status = 409;
    } elseif ($debug) {
        $message .= ' ' . $e->getMessage();
    }
    App\Core\Response::json(['success'=>false, 'message'=>$message], $status);
});
