<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use Exception;
use PDO;

class AdminSkillController extends BaseController
{
    /**
     * List all skills.
     */
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM `skills` ORDER BY `category` ASC, `sort_order` ASC");
            $skills = $stmt->fetchAll();

            $this->render('admin/skills', [
                'title'  => 'Manajemen Keahlian',
                'skills' => $skills,
            ]);

        } catch (Exception $e) {
            error_log("Skills load failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal memuat data keahlian.';
            $this->redirect('/admin/dashboard');
        }
    }

    /**
     * Store new skill in database.
     */
    public function store(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        $name             = trim($_POST['name'] ?? '');
        $category         = trim($_POST['category'] ?? '');
        $proficiencyLevel = trim($_POST['proficiency_level'] ?? '');
        $sortOrder        = (int)($_POST['sort_order'] ?? 0);
        $isActive         = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name) || empty($category)) {
            $_SESSION['flash']['error'] = 'Nama Keahlian dan Kategori wajib diisi.';
            $this->redirect('/admin/skills');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("
                INSERT INTO `skills` (`name`, `category`, `proficiency_level`, `sort_order`, `is_active`) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([$name, $category, $proficiencyLevel ?: null, $sortOrder, $isActive]);

            $_SESSION['flash']['success'] = 'Keahlian baru berhasil ditambahkan!';
        } catch (Exception $e) {
            error_log("Skill store failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Terjadi kesalahan saat menambahkan keahlian.';
        }

        $this->redirect('/admin/skills');
    }

    /**
     * Update skill in database.
     */
    public function update(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        $name             = trim($_POST['name'] ?? '');
        $category         = trim($_POST['category'] ?? '');
        $proficiencyLevel = trim($_POST['proficiency_level'] ?? '');
        $sortOrder        = (int)($_POST['sort_order'] ?? 0);
        $isActive         = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name) || empty($category)) {
            $_SESSION['flash']['error'] = 'Nama Keahlian dan Kategori wajib diisi.';
            $this->redirect('/admin/skills');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("
                UPDATE `skills` 
                SET `name` = ?, `category` = ?, `proficiency_level` = ?, `sort_order` = ?, `is_active` = ? 
                WHERE `id` = ?
            ");
            $stmt->execute([$name, $category, $proficiencyLevel ?: null, $sortOrder, $isActive, $id]);

            $_SESSION['flash']['success'] = 'Keahlian berhasil diperbarui!';
        } catch (Exception $e) {
            error_log("Skill update failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Terjadi kesalahan saat memperbarui keahlian.';
        }

        $this->redirect('/admin/skills');
    }

    /**
     * Delete skill from database.
     */
    public function delete(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM `skills` WHERE `id` = ?");
            $stmt->execute([$id]);

            $_SESSION['flash']['success'] = 'Keahlian berhasil dihapus!';
        } catch (Exception $e) {
            error_log("Skill delete failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Terjadi kesalahan saat menghapus keahlian.';
        }

        $this->redirect('/admin/skills');
    }

    /**
     * Verify CSRF protection token.
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
