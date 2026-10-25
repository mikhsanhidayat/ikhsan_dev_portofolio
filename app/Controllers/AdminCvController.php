<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Services\UploadService;
use Exception;
use PDO;

class AdminCvController extends BaseController
{
    /**
     * Display CV management page.
     */
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM `documents` WHERE `document_type` = 'cv' AND `is_active` = 1 LIMIT 1");
            $cv = $stmt->fetch();

            $this->render('admin/cv', [
                'title' => 'Manajemen CV',
                'cv'    => $cv,
            ]);

        } catch (Exception $e) {
            error_log("CV load failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal memuat data CV.';
            $this->redirect('/admin/dashboard');
        }
    }

    /**
     * Upload or replace CV file.
     */
    public function upload(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        if (!isset($_FILES['cv_file']) || $_FILES['cv_file']['error'] === UPLOAD_ERR_NO_FILE) {
            $_SESSION['flash']['error'] = 'Silakan pilih berkas PDF CV terlebih dahulu.';
            $this->redirect('/admin/cv');
        }

        try {
            $db = Database::getConnection();

            // 1. Fetch current active CV to replace
            $stmt = $db->query("SELECT * FROM `documents` WHERE `document_type` = 'cv' AND `is_active` = 1 LIMIT 1");
            $oldCv = $stmt->fetch();

            // 2. Upload file via UploadService (validates mime = pdf, size <= 10MB)
            $filePath = UploadService::uploadPdf($_FILES['cv_file'], 'documents');
            $originalName = $_FILES['cv_file']['name'];

            // 3. Save new CV in DB
            $insertStmt = $db->prepare("
                INSERT INTO `documents` (`document_type`, `file_path`, `original_name`, `is_active`) 
                VALUES ('cv', ?, ?, 1)
            ");
            $insertStmt->execute([$filePath, $originalName]);

            // 4. Delete old active CV record and physical file
            if ($oldCv) {
                // Delete physical file
                UploadService::delete($oldCv['file_path']);

                // Deactivate in DB
                $deactivateStmt = $db->prepare("UPDATE `documents` SET `is_active` = 0 WHERE `id` = ?");
                $deactivateStmt->execute([$oldCv['id']]);
            }

            $_SESSION['flash']['success'] = 'Berkas CV baru berhasil diunggah!';
            
        } catch (Exception $e) {
            error_log("CV upload failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal mengunggah CV: ' . $e->getMessage();
        }

        $this->redirect('/admin/cv');
    }

    /**
     * Delete CV document.
     */
    public function delete(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM `documents` WHERE `document_type` = 'cv' AND `is_active` = 1 LIMIT 1");
            $cv = $stmt->fetch();

            if ($cv) {
                // Delete file
                UploadService::delete($cv['file_path']);

                // Delete from DB
                $deleteStmt = $db->prepare("DELETE FROM `documents` WHERE `id` = ?");
                $deleteStmt->execute([$cv['id']]);

                $_SESSION['flash']['success'] = 'Berkas CV berhasil dihapus dari server.';
            } else {
                $_SESSION['flash']['error'] = 'Tidak ada berkas CV aktif yang dapat dihapus.';
            }

        } catch (Exception $e) {
            error_log("CV delete failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Terjadi kesalahan saat menghapus berkas CV.';
        }

        $this->redirect('/admin/cv');
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
