<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use Exception;
use PDO;

class AdminSettingController extends BaseController
{
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
