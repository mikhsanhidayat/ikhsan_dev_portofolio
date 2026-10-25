<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use Exception;
use PDO;

class AdminTechnologyController extends BaseController
{
    /**
     * List all technologies.
     */
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM `technologies` ORDER BY `id` DESC");
            $technologies = $stmt->fetchAll();

            $this->render('admin/technologies', [
                'title'        => 'Manajemen Teknologi',
                'technologies' => $technologies,
            ]);

        } catch (Exception $e) {
            error_log("Technologies load failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal memuat data teknologi.';
            $this->redirect('/admin/dashboard');
        }
    }

    /**
     * Store new technology.
     */
    public function store(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        $name     = trim($_POST['name'] ?? '');
        $icon     = trim($_POST['icon'] ?? '');
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name)) {
            $_SESSION['flash']['error'] = 'Nama Teknologi wajib diisi.';
            $this->redirect('/admin/technologies');
        }

        try {
            $db = Database::getConnection();

            // Check uniqueness
            $checkStmt = $db->prepare("SELECT id FROM `technologies` WHERE `name` = ? LIMIT 1");
            $checkStmt->execute([$name]);
            if ($checkStmt->fetch()) {
                $_SESSION['flash']['error'] = 'Teknologi dengan nama ini sudah terdaftar.';
                $this->redirect('/admin/technologies');
            }

            $stmt = $db->prepare("INSERT INTO `technologies` (`name`, `icon`, `is_active`) VALUES (?, ?, ?)");
            $stmt->execute([$name, $icon ?: null, $isActive]);

            $_SESSION['flash']['success'] = 'Teknologi baru berhasil ditambahkan!';
        } catch (Exception $e) {
            error_log("Technology store failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal menambahkan teknologi baru.';
        }

        $this->redirect('/admin/technologies');
    }

    /**
     * Update technology.
     */
    public function update(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        $name     = trim($_POST['name'] ?? '');
        $icon     = trim($_POST['icon'] ?? '');
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name)) {
            $_SESSION['flash']['error'] = 'Nama Teknologi wajib diisi.';
            $this->redirect('/admin/technologies');
        }

        try {
            $db = Database::getConnection();

            // Check uniqueness excluding current
            $checkStmt = $db->prepare("SELECT id FROM `technologies` WHERE `name` = ? AND `id` != ? LIMIT 1");
            $checkStmt->execute([$name, $id]);
            if ($checkStmt->fetch()) {
                $_SESSION['flash']['error'] = 'Teknologi dengan nama ini sudah digunakan.';
                $this->redirect('/admin/technologies');
            }

            $stmt = $db->prepare("UPDATE `technologies` SET `name` = ?, `icon` = ?, `is_active` = ? WHERE `id` = ?");
            $stmt->execute([$name, $icon ?: null, $isActive, $id]);

            $_SESSION['flash']['success'] = 'Teknologi berhasil diperbarui!';
        } catch (Exception $e) {
            error_log("Technology update failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal memperbarui teknologi.';
        }

        $this->redirect('/admin/technologies');
    }

    /**
     * Delete technology.
     */
    public function delete(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        try {
            $db = Database::getConnection();

            // Check if there are projects referencing this technology
            $stmtRef = $db->prepare("SELECT COUNT(*) FROM `project_technologies` WHERE `technology_id` = ?");
            $stmtRef->execute([$id]);
            $count = (int)$stmtRef->fetchColumn();

            if ($count > 0) {
                $_SESSION['flash']['error'] = 'Teknologi ini masih digunakan oleh ' . $count . ' proyek, silakan lepaskan relasi pada proyek terlebih dahulu sebelum menghapus.';
                $this->redirect('/admin/technologies');
            }

            $stmt = $db->prepare("DELETE FROM `technologies` WHERE `id` = ?");
            $stmt->execute([$id]);

            $_SESSION['flash']['success'] = 'Teknologi berhasil dihapus!';
        } catch (Exception $e) {
            error_log("Technology delete failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal menghapus teknologi.';
        }

        $this->redirect('/admin/technologies');
    }

    /**
     * Verify CSRF.
     */
    private function verifyCsrf(): void
    {
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (empty($csrfToken) || $csrfToken !== ($_SESSION['csrf_token'] ?? '')) {
            http_response_code(403);
            die("CSRF token tidak valid.");
        }
    }
}
