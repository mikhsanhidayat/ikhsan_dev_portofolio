<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use Exception;
use PDO;

class AdminSettingController extends BaseController
{
    public function password(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $adminId = filter_var($_SESSION['admin_id'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1]]);
        if (($_SESSION['admin_logged_in'] ?? false) !== true || $adminId === false) {
            $this->redirect('/admin/login');
            return;
        }

        $token = $_POST['csrf_token'] ?? null;
        $expected = $_SESSION['csrf_token'] ?? null;
        if (!is_string($token) || !is_string($expected) || $expected === '' || !hash_equals($expected, $token)) {
            http_response_code(403);
            echo 'Permintaan tidak dapat diproses.';
            return;
        }

        $changed = false;
        try {
            $ip = $_SERVER['REMOTE_ADDR'] ?? '';
            if (!\App\Services\RateLimiter::consumePasswordAttempt($adminId, is_string($ip) ? $ip : '')) {
                $_SESSION['flash']['error'] = 'Permintaan tidak dapat diproses. Silakan coba lagi nanti.';
                $this->redirect('/admin/settings');
                return;
            }
            $current = $_POST['current_password'] ?? null;
            $new = $_POST['new_password'] ?? null;
            $confirm = $_POST['confirm_password'] ?? null;
            if (is_string($current) && $current !== '' && \App\Services\PasswordPolicy::valid($new) && is_string($confirm) && $new === $confirm) {
                $db = Database::getConnection();
                $db->beginTransaction();
                $stmt = $db->prepare('SELECT `password` FROM `admins` WHERE `id` = ? FOR UPDATE');
                $stmt->execute([$adminId]);
                $admin = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($admin && password_verify($current, $admin['password']) && !password_verify($new, $admin['password'])) {
                    $hash = password_hash($new, PASSWORD_BCRYPT);
                    $stmt = $db->prepare('UPDATE `admins` SET `password` = ? WHERE `id` = ?');
                    $stmt->execute([$hash, $adminId]);
                    $db->commit();
                    $changed = true;
                } else {
                    $db->rollBack();
                }
            }
        } catch (\Throwable $e) {
            if (isset($db) && $db->inTransaction()) {
                $db->rollBack();
            }
        }

        if (!$changed) {
            $_SESSION['flash']['error'] = 'Kata sandi tidak dapat diperbarui. Periksa isian atau coba lagi nanti.';
            $this->redirect('/admin/settings');
            return;
        }

        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            unset($params['lifetime']);
            setcookie(session_name(), '', ['expires' => time() - 42000] + $params);
        }
        session_destroy();
        unset($_COOKIE[session_name()]);
        session_id('');
        session_start();
        $_SESSION['flash']['success'] = 'Kata sandi berhasil diperbarui. Silakan masuk kembali.';
        $this->redirect('/admin/login');
    }

    /**
     * Show the website settings form.
     */
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT `key`, `value` FROM `settings`");
            $settingsRaw = $stmt->fetchAll();

            $settings = [];
            foreach ($settingsRaw as $set) {
                $settings[$set['key']] = $set['value'];
            }

            $this->render('admin/settings', [
                'title'    => 'Pengaturan Website',
                'settings' => $settings,
            ]);

        } catch (Exception $e) {
            error_log("Settings load error: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Terjadi kesalahan memuat data pengaturan.';
            $this->redirect('/admin/dashboard');
        }
    }

    /**
     * Handle website settings update post request.
     */
    public function update(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 1. CSRF Verification
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (empty($csrfToken) || $csrfToken !== ($_SESSION['csrf_token'] ?? '')) {
            http_response_code(403);
            die("CSRF token tidak valid.");
        }

        // 2. Read Inputs
        $websiteName    = trim($_POST['website_name'] ?? '');
        $metaTitle      = trim($_POST['meta_title'] ?? '');
        $metaDescription = trim($_POST['meta_description'] ?? '');
        $footerText     = trim($_POST['footer_text'] ?? '');
        $primaryColor   = trim($_POST['primary_color'] ?? 'blue');
        $googleMapsLink = trim($_POST['google_maps_link'] ?? '');

        // 3. Validation
        if (empty($websiteName) || empty($metaTitle) || empty($metaDescription) || empty($footerText) || empty($googleMapsLink)) {
            $_SESSION['flash']['error'] = 'Semua pengaturan wajib diisi.';
            $this->redirect('/admin/settings');
        }

        // Allowed color accents
        $allowedColors = ['blue', 'indigo', 'slate'];
        if (!in_array($primaryColor, $allowedColors, true)) {
            $primaryColor = 'blue';
        }

        try {
            $db = Database::getConnection();

            // Prepare update statement
            $stmt = $db->prepare("UPDATE `settings` SET `value` = ? WHERE `key` = ?");

            $settingsToUpdate = [
                'website_name'     => $websiteName,
                'meta_title'       => $metaTitle,
                'meta_description' => $metaDescription,
                'footer_text'      => $footerText,
                'primary_color'    => $primaryColor,
                'google_maps_link' => $googleMapsLink,
            ];

            $db->beginTransaction();
            foreach ($settingsToUpdate as $key => $value) {
                $stmt->execute([$value, $key]);
            }
            $db->commit();

            $_SESSION['flash']['success'] = 'Pengaturan website berhasil diperbarui!';

        } catch (Exception $e) {
            if (isset($db) && $db->inTransaction()) {
                $db->rollBack();
            }
            error_log("Settings update failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Terjadi kesalahan sistem saat memperbarui pengaturan.';
        }

        $this->redirect('/admin/settings');
    }
}
