<?php

declare(strict_types=1);

namespace App\Middleware;

class AuthMiddleware
{
    /**
     * Handle the middleware check.
     */
    public function handle(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
            // Set error flash message
            $_SESSION['flash']['error'] = 'Silakan masuk terlebih dahulu untuk mengakses halaman administrator.';
            
            header('Location: /admin/login');
            exit;
        }
    }
}
