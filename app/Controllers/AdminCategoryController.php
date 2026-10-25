<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use Exception;
use PDO;

class AdminCategoryController extends BaseController
{
    /**
     * List all categories.
     */
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM `project_categories` ORDER BY `id` DESC");
            $categories = $stmt->fetchAll();

            $this->render('admin/categories', [
                'title'      => 'Kategori Proyek',
                'categories' => $categories,
            ]);

        } catch (Exception $e) {
            error_log("Categories load failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal memuat kategori proyek.';
            $this->redirect('/admin/dashboard');
        }
    }

    /**
     * Store new category.
     */
    public function store(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        $name     = trim($_POST['name'] ?? '');
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name)) {
            $_SESSION['flash']['error'] = 'Nama Kategori wajib diisi.';
            $this->redirect('/admin/categories');
        }

        $slug = generate_slug($name);

        try {
            $db = Database::getConnection();

            // Check uniqueness of slug
            $checkStmt = $db->prepare("SELECT id FROM `project_categories` WHERE `slug` = ? LIMIT 1");
            $checkStmt->execute([$slug]);
            if ($checkStmt->fetch()) {
                $_SESSION['flash']['error'] = 'Kategori dengan nama/slug ini sudah terdaftar.';
                $this->redirect('/admin/categories');
            }

            $stmt = $db->prepare("INSERT INTO `project_categories` (`name`, `slug`, `is_active`) VALUES (?, ?, ?)");
            $stmt->execute([$name, $slug, $isActive]);

            $_SESSION['flash']['success'] = 'Kategori baru berhasil ditambahkan!';
        } catch (Exception $e) {
            error_log("Category store failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal menambahkan kategori baru.';
        }

        $this->redirect('/admin/categories');
    }

    /**
     * Update category.
     */
    public function update(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        $name     = trim($_POST['name'] ?? '');
        $isActive = isset($_POST['is_active']) ? 1 : 0;

        if (empty($name)) {
            $_SESSION['flash']['error'] = 'Nama Kategori wajib diisi.';
            $this->redirect('/admin/categories');
        }

        $slug = generate_slug($name);

        try {
            $db = Database::getConnection();

            // Check uniqueness of slug (excluding current)
            $checkStmt = $db->prepare("SELECT id FROM `project_categories` WHERE `slug` = ? AND `id` != ? LIMIT 1");
            $checkStmt->execute([$slug, $id]);
            if ($checkStmt->fetch()) {
                $_SESSION['flash']['error'] = 'Kategori dengan nama/slug ini sudah digunakan.';
                $this->redirect('/admin/categories');
            }

            $stmt = $db->prepare("UPDATE `project_categories` SET `name` = ?, `slug` = ?, `is_active` = ? WHERE `id` = ?");
            $stmt->execute([$name, $slug, $isActive, $id]);

            $_SESSION['flash']['success'] = 'Kategori berhasil diperbarui!';
        } catch (Exception $e) {
            error_log("Category update failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal memperbarui kategori.';
        }

        $this->redirect('/admin/categories');
    }

    /**
     * Delete category.
     */
    public function delete(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        try {
            $db = Database::getConnection();

            // Check if there are projects referencing this category
            $projStmt = $db->prepare("SELECT COUNT(*) FROM `projects` WHERE `category_id` = ?");
            $projStmt->execute([$id]);
            $count = (int)$projStmt->fetchColumn();

            if ($count > 0) {
                $_SESSION['flash']['error'] = 'Kategori ini tidak dapat dihapus karena masih digunakan oleh ' . $count . ' proyek.';
                $this->redirect('/admin/categories');
            }

            $stmt = $db->prepare("DELETE FROM `project_categories` WHERE `id` = ?");
            $stmt->execute([$id]);

            $_SESSION['flash']['success'] = 'Kategori berhasil dihapus!';
        } catch (Exception $e) {
            error_log("Category delete failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal menghapus kategori.';
        }

        $this->redirect('/admin/categories');
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
