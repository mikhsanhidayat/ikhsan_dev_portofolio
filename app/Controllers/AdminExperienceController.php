<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use Exception;
use PDO;

class AdminExperienceController extends BaseController
{
    /**
     * List all experiences.
     */
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM `experiences` ORDER BY `sort_order` ASC, `start_date` DESC");
            $experiences = $stmt->fetchAll();

            $this->render('admin/experience', [
                'title'       => 'Pengalaman (Opsional)',
                'experiences' => $experiences,
            ]);

        } catch (Exception $e) {
            error_log("Experience load failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal memuat data pengalaman.';
            $this->redirect('/admin/dashboard');
        }
    }

    /**
     * Store new experience.
     */
    public function store(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        $organizationName = trim($_POST['organization_name'] ?? '');
        $role             = trim($_POST['role'] ?? '');
        $experienceType   = trim($_POST['experience_type'] ?? '');
        $startDate        = trim($_POST['start_date'] ?? '');
        $isCurrent        = isset($_POST['is_current']) ? 1 : 0;
        $endDate          = (!$isCurrent && !empty($_POST['end_date'])) ? trim($_POST['end_date']) : null;
        $description      = trim($_POST['description'] ?? '');
        $sortOrder        = (int)($_POST['sort_order'] ?? 0);
        $isActive         = isset($_POST['is_active']) ? 1 : 0;

        if (empty($organizationName) || empty($role) || empty($experienceType) || empty($startDate) || empty($description)) {
            $_SESSION['flash']['error'] = 'Seluruh field bertanda bintang (*) wajib diisi.';
            $this->redirect('/admin/experience');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("
                INSERT INTO `experiences` 
                (`organization_name`, `role`, `experience_type`, `start_date`, `end_date`, `is_current`, `description`, `sort_order`, `is_active`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $organizationName,
                $role,
                $experienceType,
                $startDate,
                $endDate,
                $isCurrent,
                $description,
                $sortOrder,
                $isActive
            ]);

            $_SESSION['flash']['success'] = 'Data pengalaman berhasil ditambahkan!';
        } catch (Exception $e) {
            error_log("Experience store failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal menambahkan data pengalaman.';
        }

        $this->redirect('/admin/experience');
    }

    /**
     * Update experience.
     */
    public function update(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        $organizationName = trim($_POST['organization_name'] ?? '');
        $role             = trim($_POST['role'] ?? '');
        $experienceType   = trim($_POST['experience_type'] ?? '');
        $startDate        = trim($_POST['start_date'] ?? '');
        $isCurrent        = isset($_POST['is_current']) ? 1 : 0;
        $endDate          = (!$isCurrent && !empty($_POST['end_date'])) ? trim($_POST['end_date']) : null;
        $description      = trim($_POST['description'] ?? '');
        $sortOrder        = (int)($_POST['sort_order'] ?? 0);
        $isActive         = isset($_POST['is_active']) ? 1 : 0;

        if (empty($organizationName) || empty($role) || empty($experienceType) || empty($startDate) || empty($description)) {
            $_SESSION['flash']['error'] = 'Seluruh field bertanda bintang (*) wajib diisi.';
            $this->redirect('/admin/experience');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("
                UPDATE `experiences` SET 
                    `organization_name` = ?, 
                    `role` = ?, 
                    `experience_type` = ?, 
                    `start_date` = ?, 
                    `end_date` = ?, 
                    `is_current` = ?, 
                    `description` = ?, 
                    `sort_order` = ?, 
                    `is_active` = ? 
                WHERE `id` = ?
            ");
            $stmt->execute([
                $organizationName,
                $role,
                $experienceType,
                $startDate,
                $endDate,
                $isCurrent,
                $description,
                $sortOrder,
                $isActive,
                $id
            ]);

            $_SESSION['flash']['success'] = 'Data pengalaman berhasil diperbarui!';
        } catch (Exception $e) {
            error_log("Experience update failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal memperbarui data pengalaman.';
        }

        $this->redirect('/admin/experience');
    }

    /**
     * Delete experience.
     */
    public function delete(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM `experiences` WHERE `id` = ?");
            $stmt->execute([$id]);

            $_SESSION['flash']['success'] = 'Data pengalaman berhasil dihapus!';
        } catch (Exception $e) {
            error_log("Experience delete failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal menghapus data pengalaman.';
        }

        $this->redirect('/admin/experience');
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
