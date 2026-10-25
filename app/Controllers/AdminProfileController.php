<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Services\UploadService;
use Exception;
use PDO;

class AdminProfileController extends BaseController
{
    /**
     * Show the profile edit form.
     */
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM `profiles` LIMIT 1");
            $profile = $stmt->fetch();

            if (!$profile) {
                // Fail-safe: if seeder wasn't run, create a blank record
                $db->exec("
                    INSERT INTO `profiles` (`full_name`, `headline`, `internship_target`, `short_bio`, `about_text`, `email`) 
                    VALUES ('Nama Lengkap', 'Headline', 'Target Posisi', 'Short Bio', 'About Text', 'admin@example.com')
                ");
                $profile = $db->query("SELECT * FROM `profiles` LIMIT 1")->fetch();
            }

            $this->render('admin/profile', [
                'title'   => 'Manajemen Profil',
                'profile' => $profile,
            ]);

        } catch (Exception $e) {
            error_log("Profile load error: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Terjadi kesalahan memuat data profil.';
            $this->redirect('/admin/dashboard');
        }
    }

    /**
     * Handle profile update post request.
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

        // 2. Validate Inputs
        $fullName         = trim($_POST['full_name'] ?? '');
        $headline         = trim($_POST['headline'] ?? '');
        $internshipTarget = trim($_POST['internship_target'] ?? '');
        $shortBio         = trim($_POST['short_bio'] ?? '');
        $aboutText        = trim($_POST['about_text'] ?? '');
        $email            = trim($_POST['email'] ?? '');
        $whatsapp         = trim($_POST['whatsapp'] ?? '');
        $githubUrl        = trim($_POST['github_url'] ?? '');
        $linkedinUrl      = trim($_POST['linkedin_url'] ?? '');
        $instagramUrl     = trim($_POST['instagram_url'] ?? '');
        $tiktokUrl        = trim($_POST['tiktok_url'] ?? '');
        $youtubeUrl       = trim($_POST['youtube_url'] ?? '');
        $location         = trim($_POST['location'] ?? '');
        $availability     = isset($_POST['availability_status']) ? 1 : 0;

        if (empty($fullName) || empty($headline) || empty($internshipTarget) || empty($shortBio) || empty($aboutText) || empty($email)) {
            $_SESSION['flash']['error'] = 'Seluruh field wajib (Nama, Headline, Target Magang, Ringkasan, Tentang Saya, Email) harus diisi.';
            $this->redirect('/admin/profile');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['flash']['error'] = 'Format email tidak valid.';
            $this->redirect('/admin/profile');
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->query("SELECT * FROM `profiles` LIMIT 1");
            $profile = $stmt->fetch();

            $photoPath = $profile['profile_photo'] ?? null;

            // 3. Handle File Upload (profile photo)
            if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] !== UPLOAD_ERR_NO_FILE) {
                try {
                    // Upload and compress image (resize to max 500x500 for profile photo)
                    $uploadResult = UploadService::uploadImage($_FILES['profile_photo'], 'profile', 500, 500);
                    
                    // Delete old file if exists
                    if (!empty($photoPath)) {
                        UploadService::delete($photoPath);
                    }
                    
                    $photoPath = $uploadResult['image_path'];
                } catch (Exception $uploadEx) {
                    $_SESSION['flash']['error'] = 'Gagal mengunggah foto: ' . $uploadEx->getMessage();
                    $this->redirect('/admin/profile');
                }
            }

            // 4. Update Profile Record
            $updateStmt = $db->prepare("
                UPDATE `profiles` SET 
                    `full_name` = ?, 
                    `headline` = ?, 
                    `internship_target` = ?, 
                    `short_bio` = ?, 
                    `about_text` = ?, 
                    `profile_photo` = ?, 
                    `location` = ?, 
                    `availability_status` = ?, 
                    `email` = ?, 
                    `whatsapp` = ?, 
                    `github_url` = ?, 
                    `linkedin_url` = ?,
                    `instagram_url` = ?,
                    `tiktok_url` = ?,
                    `youtube_url` = ? 
                WHERE `id` = ?
            ");

            $updateStmt->execute([
                $fullName,
                $headline,
                $internshipTarget,
                $shortBio,
                $aboutText,
                $photoPath,
                $location,
                $availability,
                $email,
                $whatsapp,
                $githubUrl,
                $linkedinUrl,
                $instagramUrl,
                $tiktokUrl,
                $youtubeUrl,
                $profile['id']
            ]);

            $_SESSION['flash']['success'] = 'Profil berhasil diperbarui!';
            
        } catch (Exception $e) {
            error_log("Profile update failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Terjadi kesalahan sistem saat memperbarui profil.';
        }

        $this->redirect('/admin/profile');
    }
}
