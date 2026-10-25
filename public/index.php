<?php

declare(strict_types=1);

// 1. Load Composer Autoloader & Helpers
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../app/Helpers/helpers.php';

// 2. Load Environment Variables
try {
    if (file_exists(__DIR__ . '/../.env')) {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
        $dotenv->load();
    } else {
        throw new RuntimeException('.env file is missing. Please create it from .env.example');
    }
} catch (Exception $e) {
    die("Configuration error: " . $e->getMessage());
}

// 3. Setup Error Logging & Display Settings
$debug = filter_var($_ENV['APP_DEBUG'] ?? false, FILTER_VALIDATE_BOOLEAN);
$env   = $_ENV['APP_ENV'] ?? 'production';

error_reporting(E_ALL);

// Ensure the storage/logs directory exists
$logDir = __DIR__ . '/../storage/logs';
if (!is_dir($logDir)) {
    mkdir($logDir, 0755, true);
}
ini_set('log_errors', '1');
ini_set('error_log', $logDir . '/error.log');

if ($debug) {
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
} else {
    ini_set('display_errors', '0');
    ini_set('display_startup_errors', '0');
}

// 4. Initialize Secure Session
$sessionLifetime = (int)($_ENV['SESSION_LIFETIME'] ?? 120) * 60; // Convert minutes to seconds

// Set cookie parameters
session_set_cookie_params([
    'lifetime' => $sessionLifetime,
    'path' => '/',
    'domain' => '',
    'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
    'httponly' => true,
    'samesite' => 'Lax'
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear old input on GET requests to prevent stale inputs
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // If not reloading, we can clear it. To be safe, we just clear old input at the end of execution
    // but we can register a shutdown function to clear old input from session.
    register_shutdown_function(function() {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            unset($_SESSION['old_input']);
        }
    });
}

// 5. Setup Security Headers
header('X-Frame-Options: SAMEORIGIN');
header('X-Content-Type-Options: nosniff');
header('X-XSS-Protection: 1; mode=block');
header('Referrer-Policy: no-referrer-when-downgrade');
// Content-Security-Policy (CSP) - relaxed enough for local/admin assets but protective
header("Content-Security-Policy: default-src 'self'; script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.tailwindcss.com https://unpkg.com https://cdn.jsdelivr.net; style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.tailwindcss.com https://cdn.jsdelivr.net; font-src 'self' https://fonts.gstatic.com; img-src 'self' data: https:; frame-src 'self' https://www.youtube.com https://www.google.com https://maps.google.com; connect-src 'self';");

// 6. Routing Setup & Dispatch
$router = new App\Core\Router();

require_once __DIR__ . '/../routes/web.php';

$router->dispatch($_SERVER['REQUEST_URI'], $_SERVER['REQUEST_METHOD']);
