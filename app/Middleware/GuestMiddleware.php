<?php

declare(strict_types=1);

namespace App\Middleware;

class GuestMiddleware
{
    /**
     * Handle the middleware check.
     */
    public function handle(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!empty($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
            header('Location: /admin/dashboard');
            exit;
        }
    }
}
