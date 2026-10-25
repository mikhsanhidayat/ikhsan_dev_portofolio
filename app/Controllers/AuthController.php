<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Services\RateLimiter;
use PDO;

class AuthController extends BaseController
{
    /**
     * Show the admin login form.
     */
    public function showLogin(): void
    {
        $this->render('admin/login', [
            'title' => 'Masuk Administrator',
        ]);
    }

    /**
     * Handle login post request.
     */
    public function login(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';
        $limiterKey = 'login_attempt_' . $ip;

        // 1. Honeypot check
        $honeypot = $_POST['username_hp'] ?? '';
        if (!empty($honeypot)) {
            // Bot detected, fail silently with generic error
            sleep(2); // Slow down bot
            $_SESSION['flash']['error'] = 'Gagal memproses login.';
            $this->redirect('/admin/login');
        }

        // 2. CSRF check
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (empty($csrfToken) || $csrfToken !== ($_SESSION['csrf_token'] ?? '')) {
            http_response_code(403);
            die("CSRF token tidak valid. Silakan muat ulang halaman.");
        }

        // 3. Rate Limit check
        $maxAttempts = (int)($_ENV['LOGIN_LIMIT_ATTEMPTS'] ?? 5);
        $decaySeconds = (int)($_ENV['LOGIN_LIMIT_TIMEOUT'] ?? 900);

        if (!RateLimiter::check($limiterKey, $maxAttempts, $decaySeconds)) {
            $remaining = RateLimiter::getDecayTimeRemaining($limiterKey, $decaySeconds);
            $minutes = ceil($remaining / 60);
            $_SESSION['flash']['error'] = "Terlalu banyak percobaan login gagal. Anda diblokir selama {$minutes} menit.";
            $this->redirect('/admin/login');
        }

        // Keep old input for convenience (except password)
        $email = trim($_POST['email'] ?? '');
        $_SESSION['old_input'] = ['email' => $email];

        if (empty($email) || empty($_POST['password'])) {
            RateLimiter::hit($limiterKey);
            $_SESSION['flash']['error'] = 'Silakan isi email dan kata sandi.';
            $this->redirect('/admin/login');
        }

        $password = $_POST['password'];

        try {
            $db = Database::getConnection();

            // Fetch admin account
            $stmt = $db->prepare("SELECT * FROM `admins` WHERE `email` = ? LIMIT 1");
            $stmt->execute([$email]);
            $admin = $stmt->fetch();

            if ($admin && password_verify($password, $admin['password'])) {
                // Success: clear rate limiter logs
                RateLimiter::clear($limiterKey);

                // Regenerate session ID for security
                session_regenerate_id(true);

                // Save session credentials
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $admin['id'];
                $_SESSION['admin_name'] = $admin['name'];
                $_SESSION['admin_email'] = $admin['email'];

                // Remove old inputs
                unset($_SESSION['old_input']);

                // Update last login timestamp in DB
                $updateStmt = $db->prepare("UPDATE `admins` SET `last_login_at` = NOW() WHERE `id` = ?");
                $updateStmt->execute([$admin['id']]);

                $_SESSION['flash']['success'] = "Selamat datang kembali, " . $admin['name'] . "!";
                $this->redirect('/admin/dashboard');
            }

            // Failure (either incorrect email or incorrect password)
            RateLimiter::hit($limiterKey);
            
            // Masking errors
            $_SESSION['flash']['error'] = 'Email atau kata sandi salah.';
            $this->redirect('/admin/login');

        } catch (\Exception $e) {
            error_log("Login Error: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Terjadi kesalahan sistem saat mencoba masuk.';
            $this->redirect('/admin/login');
        }
    }

    /**
     * Handle logout request.
     */
    public function logout(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // CSRF verification on logout to prevent CSRF-triggered logout attacks
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (empty($csrfToken) || $csrfToken !== ($_SESSION['csrf_token'] ?? '')) {
            http_response_code(403);
            die("CSRF token tidak valid saat logout.");
        }

        // Clear session variables
        $_SESSION = [];

        // Delete session cookie
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000,
                $params["path"], $params["domain"],
                $params["secure"], $params["httponly"]
            );
        }

        // Destroy session
        session_destroy();

        // Start a fresh session to hold the success message
        session_start();
        $_SESSION['flash']['success'] = 'Anda telah berhasil keluar.';
        
        $this->redirect('/admin/login');
    }
}
