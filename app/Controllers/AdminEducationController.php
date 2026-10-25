<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use Exception;
use PDO;

class AdminEducationController extends BaseController
{
    /**
     * List all educations.
     */
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM `educations` ORDER BY `sort_order` ASC, `start_year` DESC");
            $educations = $stmt->fetchAll();

            $this->render('admin/education', [
                'title'      => 'Pendidikan',
                'educations' => $educations,
            ]);

        } catch (Exception $e) {
            error_log("Education load failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal memuat data pendidikan.';
            $this->redirect('/admin/dashboard');
        }
    }

    /**
     * Store new education.
     */
    public function store(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        $institutionName = trim($_POST['institution_name'] ?? '');
        $studyProgram    = trim($_POST['study_program'] ?? '');
        $degree          = trim($_POST['degree'] ?? '');
        $startYear       = (int)($_POST['start_year'] ?? 0);
        $endYear         = !empty($_POST['end_year']) ? (int)$_POST['end_year'] : null;
        $description     = trim($_POST['description'] ?? '');
        $sortOrder       = (int)($_POST['sort_order'] ?? 0);
        $isActive        = isset($_POST['is_active']) ? 1 : 0;

        if (empty($institutionName) || empty($studyProgram) || empty($degree) || $startYear <= 0) {
            $_SESSION['flash']['error'] = 'Nama Institusi, Program Studi, Jenjang, dan Tahun Mulai wajib diisi.';
            $this->redirect('/admin/education');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("
                INSERT INTO `educations` 
                (`institution_name`, `study_program`, `degree`, `start_year`, `end_year`, `description`, `sort_order`, `is_active`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $institutionName,
                $studyProgram,
                $degree,
                $startYear,
                $endYear,
                $description ?: null,
                $sortOrder,
                $isActive
            ]);

            $_SESSION['flash']['success'] = 'Data pendidikan berhasil ditambahkan!';
        } catch (Exception $e) {
            error_log("Education store failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal menambahkan data pendidikan.';
        }

        $this->redirect('/admin/education');
    }

    /**
     * Update education.
     */
    public function update(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        $institutionName = trim($_POST['institution_name'] ?? '');
        $studyProgram    = trim($_POST['study_program'] ?? '');
        $degree          = trim($_POST['degree'] ?? '');
        $startYear       = (int)($_POST['start_year'] ?? 0);
        $endYear         = !empty($_POST['end_year']) ? (int)$_POST['end_year'] : null;
        $description     = trim($_POST['description'] ?? '');
        $sortOrder       = (int)($_POST['sort_order'] ?? 0);
        $isActive        = isset($_POST['is_active']) ? 1 : 0;

        if (empty($institutionName) || empty($studyProgram) || empty($degree) || $startYear <= 0) {
            $_SESSION['flash']['error'] = 'Nama Institusi, Program Studi, Jenjang, dan Tahun Mulai wajib diisi.';
            $this->redirect('/admin/education');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("
                UPDATE `educations` SET 
                    `institution_name` = ?, 
                    `study_program` = ?, 
                    `degree` = ?, 
                    `start_year` = ?, 
                    `end_year` = ?, 
                    `description` = ?, 
                    `sort_order` = ?, 
                    `is_active` = ? 
                WHERE `id` = ?
            ");
            $stmt->execute([
                $institutionName,
                $studyProgram,
                $degree,
                $startYear,
                $endYear,
                $description ?: null,
                $sortOrder,
                $isActive,
                $id
            ]);

            $_SESSION['flash']['success'] = 'Data pendidikan berhasil diperbarui!';
        } catch (Exception $e) {
            error_log("Education update failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal memperbarui data pendidikan.';
        }

        $this->redirect('/admin/education');
    }

    /**
     * Delete education.
     */
    public function delete(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM `educations` WHERE `id` = ?");
            $stmt->execute([$id]);

            $_SESSION['flash']['success'] = 'Data pendidikan berhasil dihapus!';
        } catch (Exception $e) {
            error_log("Education delete failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal menghapus data pendidikan.';
        }

        $this->redirect('/admin/education');
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
