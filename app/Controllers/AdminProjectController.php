<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use App\Services\UploadService;
use Exception;
use PDO;

class AdminProjectController extends BaseController
{
    /**
     * List all projects.
     */
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->query("
                SELECT p.*, c.name as category_name 
                FROM `projects` p
                LEFT JOIN `project_categories` c ON p.category_id = c.id
                ORDER BY p.sort_order ASC, p.created_at DESC
            ");
            $projects = $stmt->fetchAll();

            $this->render('admin/projects/index', [
                'title'    => 'Manajemen Proyek',
                'projects' => $projects,
            ]);

        } catch (Exception $e) {
            error_log("Projects load failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal memuat data proyek.';
            $this->redirect('/admin/dashboard');
        }
    }

    /**
     * Show create project form.
     */
    public function create(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $db = Database::getConnection();
            
            $categories = $db->query("SELECT * FROM `project_categories` WHERE `is_active` = 1 ORDER BY `name` ASC")->fetchAll();
            $technologies = $db->query("SELECT * FROM `technologies` WHERE `is_active` = 1 ORDER BY `name` ASC")->fetchAll();

            $this->render('admin/projects/create', [
                'title'        => 'Tambah Proyek Baru',
                'categories'   => $categories,
                'technologies' => $technologies,
            ]);

        } catch (Exception $e) {
            error_log("Project create page error: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal memuat form tambah proyek.';
            $this->redirect('/admin/projects');
        }
    }

    /**
     * Store new project.
     */
    public function store(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        // 1. Validate Text Inputs
        $title          = trim($_POST['title'] ?? '');
        $categoryId     = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
        $summary        = trim($_POST['summary'] ?? '');
        $background     = trim($_POST['background'] ?? '');
        $objective      = trim($_POST['objective'] ?? '');
        $solution       = trim($_POST['solution'] ?? '');
        $roleDesc       = trim($_POST['role_description'] ?? '');
        $processDesc    = trim($_POST['process_description'] ?? '');
        $featureDesc    = trim($_POST['feature_description'] ?? '');
        $resultDesc     = trim($_POST['result_description'] ?? '');
        $challengeDesc  = trim($_POST['challenge_description'] ?? '');
        $startDate      = trim($_POST['start_date'] ?? '');
        $endDate        = !empty($_POST['end_date']) ? trim($_POST['end_date']) : null;
        $projectStatus  = trim($_POST['project_status'] ?? '');
        $demoUrl        = trim($_POST['demo_url'] ?? '');
        $githubUrl      = trim($_POST['github_url'] ?? '');
        $videoUrl       = trim($_POST['video_url'] ?? '');
        $pubStatus      = trim($_POST['publication_status'] ?? 'draft');
        $isFeatured     = isset($_POST['is_featured']) ? 1 : 0;
        $sortOrder      = (int)($_POST['sort_order'] ?? 0);
        $techIds        = $_POST['technologies'] ?? []; // Array of technology IDs

        if (empty($title) || empty($summary) || empty($background) || empty($objective) || empty($solution) 
            || empty($roleDesc) || empty($processDesc) || empty($featureDesc) || empty($resultDesc) 
            || empty($startDate) || empty($projectStatus)) {
            $_SESSION['flash']['error'] = 'Mohon lengkapi seluruh kolom wajib yang bertanda bintang (*).';
            $this->redirect('/admin/projects/create');
        }

        // Generate Slug
        $slug = generate_slug($title);

        try {
            $db = Database::getConnection();

            // Check slug uniqueness
            $checkStmt = $db->prepare("SELECT id FROM `projects` WHERE `slug` = ? LIMIT 1");
            $checkStmt->execute([$slug]);
            if ($checkStmt->fetch()) {
                $_SESSION['flash']['error'] = 'Proyek dengan judul/slug ini sudah terdaftar.';
                $this->redirect('/admin/projects/create');
            }

            // 2. Handle Cover Image Upload
            if (!isset($_FILES['cover_image']) || $_FILES['cover_image']['error'] === UPLOAD_ERR_NO_FILE) {
                $_SESSION['flash']['error'] = 'Gambar cover proyek wajib diunggah.';
                $this->redirect('/admin/projects/create');
            }

            $uploadResult = UploadService::uploadImage($_FILES['cover_image'], 'projects/covers', 1200, 1200, true);
            $coverPath = $uploadResult['image_path'];

            // Start Transaction to guarantee relational synchronization
            $db->beginTransaction();

            $stmt = $db->prepare("
                INSERT INTO `projects` (
                    `category_id`, `title`, `slug`, `summary`, `background`, `objective`, `solution`, 
                    `role_description`, `process_description`, `feature_description`, `result_description`, 
                    `challenge_description`, `cover_image`, `start_date`, `end_date`, `project_status`, 
                    `demo_url`, `github_url`, `video_url`, `publication_status`, `is_featured`, `sort_order`, `published_at`
                ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)
            ");

            $publishedAt = ($pubStatus === 'published') ? date('Y-m-d H:i:s') : null;

            $stmt->execute([
                $categoryId, $title, $slug, $summary, $background, $objective, $solution,
                $roleDesc, $processDesc, $featureDesc, $resultDesc,
                $challengeDesc ?: null, $coverPath, $startDate, $endDate, $projectStatus,
                $demoUrl ?: null, $githubUrl ?: null, $videoUrl ?: null, $pubStatus, $isFeatured, $sortOrder, $publishedAt
            ]);

            $projectId = (int)$db->lastInsertId();

            // Insert technologies relationship
            if (!empty($techIds)) {
                $techStmt = $db->prepare("INSERT INTO `project_technologies` (`project_id`, `technology_id`) VALUES (?, ?)");
                foreach ($techIds as $techId) {
                    $techStmt->execute([$projectId, (int)$techId]);
                }
            }

            $db->commit();
            $_SESSION['flash']['success'] = 'Proyek baru berhasil diterbitkan!';
            $this->redirect('/admin/projects');

        } catch (Exception $e) {
            if (isset($db) && $db->inTransaction()) {
                $db->rollBack();
            }
            error_log("Project store failure: " . $e->getMessage());
            // Cleanup cover file if uploaded but database write failed
            if (isset($coverPath)) {
                UploadService::delete($coverPath);
                // Delete thumbnail too
                $thumbPath = str_replace('projects/covers/', 'projects/covers/thumbs/thumb_', $coverPath);
                UploadService::delete($thumbPath);
            }
            $_SESSION['flash']['error'] = 'Terjadi kesalahan saat menyimpan proyek: ' . $e->getMessage();
            $this->redirect('/admin/projects/create');
        }
    }

    /**
     * Show edit project form.
     */
    public function edit(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $db = Database::getConnection();

            // Fetch Project
            $stmt = $db->prepare("SELECT * FROM `projects` WHERE `id` = ? LIMIT 1");
            $stmt->execute([$id]);
            $project = $stmt->fetch();

            if (!$project) {
                $_SESSION['flash']['error'] = 'Proyek tidak ditemukan.';
                $this->redirect('/admin/projects');
            }

            $categories = $db->query("SELECT * FROM `project_categories` WHERE `is_active` = 1 ORDER BY `name` ASC")->fetchAll();
            $technologies = $db->query("SELECT * FROM `technologies` WHERE `is_active` = 1 ORDER BY `name` ASC")->fetchAll();

            // Fetch currently linked technologies
            $linkedStmt = $db->prepare("SELECT technology_id FROM `project_technologies` WHERE `project_id` = ?");
            $linkedStmt->execute([$id]);
            $linkedTechs = $linkedStmt->fetchAll(PDO::FETCH_COLUMN);

            $this->render('admin/projects/edit', [
                'title'        => 'Ubah Proyek: ' . $project['title'],
                'project'      => $project,
                'categories'   => $categories,
                'technologies' => $technologies,
                'linkedTechs'  => $linkedTechs,
            ]);

        } catch (Exception $e) {
            error_log("Project edit page load failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal memuat form ubah proyek.';
            $this->redirect('/admin/projects');
        }
    }

    /**
     * Update project.
     */
    public function update(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        // 1. Validate Text Inputs
        $title          = trim($_POST['title'] ?? '');
        $categoryId     = !empty($_POST['category_id']) ? (int)$_POST['category_id'] : null;
        $summary        = trim($_POST['summary'] ?? '');
        $background     = trim($_POST['background'] ?? '');
        $objective      = trim($_POST['objective'] ?? '');
        $solution       = trim($_POST['solution'] ?? '');
        $roleDesc       = trim($_POST['role_description'] ?? '');
        $processDesc    = trim($_POST['process_description'] ?? '');
        $featureDesc    = trim($_POST['feature_description'] ?? '');
        $resultDesc     = trim($_POST['result_description'] ?? '');
        $challengeDesc  = trim($_POST['challenge_description'] ?? '');
        $startDate      = trim($_POST['start_date'] ?? '');
        $endDate        = !empty($_POST['end_date']) ? trim($_POST['end_date']) : null;
        $projectStatus  = trim($_POST['project_status'] ?? '');
        $demoUrl        = trim($_POST['demo_url'] ?? '');
        $githubUrl      = trim($_POST['github_url'] ?? '');
        $videoUrl       = trim($_POST['video_url'] ?? '');
        $pubStatus      = trim($_POST['publication_status'] ?? 'draft');
        $isFeatured     = isset($_POST['is_featured']) ? 1 : 0;
        $sortOrder      = (int)($_POST['sort_order'] ?? 0);
        $techIds        = $_POST['technologies'] ?? [];

        if (empty($title) || empty($summary) || empty($background) || empty($objective) || empty($solution) 
            || empty($roleDesc) || empty($processDesc) || empty($featureDesc) || empty($resultDesc) 
            || empty($startDate) || empty($projectStatus)) {
            $_SESSION['flash']['error'] = 'Mohon lengkapi seluruh kolom wajib yang bertanda bintang (*).';
            $this->redirect("/admin/projects/edit/{$id}");
        }

        $slug = generate_slug($title);

        try {
            $db = Database::getConnection();

            // Check slug uniqueness (excluding current)
            $checkStmt = $db->prepare("SELECT id FROM `projects` WHERE `slug` = ? AND `id` != ? LIMIT 1");
            $checkStmt->execute([$slug, $id]);
            if ($checkStmt->fetch()) {
                $_SESSION['flash']['error'] = 'Proyek dengan judul/slug ini sudah terdaftar.';
                $this->redirect("/admin/projects/edit/{$id}");
            }

            // Fetch current cover image to clean up if a new one is uploaded
            $projStmt = $db->prepare("SELECT cover_image, published_at FROM `projects` WHERE `id` = ? LIMIT 1");
            $projStmt->execute([$id]);
            $currentProj = $projStmt->fetch();

            if (!$currentProj) {
                $_SESSION['flash']['error'] = 'Proyek tidak ditemukan.';
                $this->redirect('/admin/projects');
            }

            $coverPath = $currentProj['cover_image'];
            $newCoverUploaded = false;

            // 2. Handle Cover Image Replacement
            if (isset($_FILES['cover_image']) && $_FILES['cover_image']['error'] !== UPLOAD_ERR_NO_FILE) {
                $uploadResult = UploadService::uploadImage($_FILES['cover_image'], 'projects/covers', 1200, 1200, true);
                $newCoverPath = $uploadResult['image_path'];
                $newCoverUploaded = true;
            }

            // Start transaction
            $db->beginTransaction();

            $updateStmt = $db->prepare("
                UPDATE `projects` SET 
                    `category_id` = ?, 
                    `title` = ?, 
                    `slug` = ?, 
                    `summary` = ?, 
                    `background` = ?, 
                    `objective` = ?, 
                    `solution` = ?, 
                    `role_description` = ?, 
                    `process_description` = ?, 
                    `feature_description` = ?, 
                    `result_description` = ?, 
                    `challenge_description` = ?, 
                    `cover_image` = ?, 
                    `start_date` = ?, 
                    `end_date` = ?, 
                    `project_status` = ?, 
                    `demo_url` = ?, 
                    `github_url` = ?, 
                    `video_url` = ?, 
                    `publication_status` = ?, 
                    `is_featured` = ?, 
                    `sort_order` = ?, 
                    `published_at` = ?
                WHERE `id` = ?
            ");

            // Calculate published_at timestamp
            $publishedAt = $currentProj['published_at'];
            if ($pubStatus === 'published' && empty($publishedAt)) {
                $publishedAt = date('Y-m-d H:i:s');
            } elseif ($pubStatus === 'draft') {
                $publishedAt = null;
            }

            $activeCover = $newCoverUploaded ? $newCoverPath : $coverPath;

            $updateStmt->execute([
                $categoryId, $title, $slug, $summary, $background, $objective, $solution,
                $roleDesc, $processDesc, $featureDesc, $resultDesc,
                $challengeDesc ?: null, $activeCover, $startDate, $endDate, $projectStatus,
                $demoUrl ?: null, $githubUrl ?: null, $videoUrl ?: null, $pubStatus, $isFeatured, $sortOrder, $publishedAt,
                $id
            ]);

            // Sync technologies: delete old relationship first, then insert new ones
            $delTechStmt = $db->prepare("DELETE FROM `project_technologies` WHERE `project_id` = ?");
            $delTechStmt->execute([$id]);

            if (!empty($techIds)) {
                $insTechStmt = $db->prepare("INSERT INTO `project_technologies` (`project_id`, `technology_id`) VALUES (?, ?)");
                foreach ($techIds as $techId) {
                    $insTechStmt->execute([$id, (int)$techId]);
                }
            }

            $db->commit();

            // If replacement was successful, clean up old file from server
            if ($newCoverUploaded) {
                UploadService::delete($coverPath);
                // Delete old thumbnail
                $oldThumbPath = str_replace('projects/covers/', 'projects/covers/thumbs/thumb_', $coverPath);
                UploadService::delete($oldThumbPath);
            }

            $_SESSION['flash']['success'] = 'Proyek berhasil diperbarui!';
            $this->redirect('/admin/projects');

        } catch (Exception $e) {
            if (isset($db) && $db->inTransaction()) {
                $db->rollBack();
            }
            error_log("Project update failure: " . $e->getMessage());
            // Cleanup new cover file if database update failed
            if (isset($newCoverPath)) {
                UploadService::delete($newCoverPath);
                $newThumbPath = str_replace('projects/covers/', 'projects/covers/thumbs/thumb_', $newCoverPath);
                UploadService::delete($newThumbPath);
            }
            $_SESSION['flash']['error'] = 'Gagal memperbarui proyek: ' . $e->getMessage();
            $this->redirect("/admin/projects/edit/{$id}");
        }
    }

    /**
     * Delete project (cascade delete dependencies and physical files).
     */
    public function delete(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        try {
            $db = Database::getConnection();

            // Fetch cover image and other media paths to delete files from server disk
            $projStmt = $db->prepare("SELECT cover_image FROM `projects` WHERE `id` = ? LIMIT 1");
            $projStmt->execute([$id]);
            $project = $projStmt->fetch();

            if (!$project) {
                $_SESSION['flash']['error'] = 'Proyek tidak ditemukan.';
                $this->redirect('/admin/projects');
            }

            // Fetch all associated gallery media to delete physical files
            $mediaStmt = $db->prepare("SELECT file_path FROM `project_media` WHERE `project_id` = ?");
            $mediaStmt->execute([$id]);
            $galleryPhotos = $mediaStmt->fetchAll(PDO::FETCH_COLUMN);

            // Start database deletion
            $db->beginTransaction();

            $stmt = $db->prepare("DELETE FROM `projects` WHERE `id` = ?");
            $stmt->execute([$id]);

            $db->commit();

            // Database cascade delete was successful -> Clean up physical files from disk
            // 1. Delete cover image
            UploadService::delete($project['cover_image']);
            $coverThumb = str_replace('projects/covers/', 'projects/covers/thumbs/thumb_', $project['cover_image']);
            UploadService::delete($coverThumb);

            // 2. Delete gallery photos
            foreach ($galleryPhotos as $photoPath) {
                if ($photoPath) {
                    UploadService::delete($photoPath);
                    $galleryThumb = str_replace('projects/gallery/', 'projects/gallery/thumbs/thumb_', $photoPath);
                    UploadService::delete($galleryThumb);
                }
            }

            $_SESSION['flash']['success'] = 'Proyek beserta seluruh foto galeri dokumentasi telah berhasil dihapus secara bersih.';

        } catch (Exception $e) {
            if (isset($db) && $db->inTransaction()) {
                $db->rollBack();
            }
            error_log("Project delete error: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal menghapus proyek: ' . $e->getMessage();
        }

        $this->redirect('/admin/projects');
    }

    // ==========================================
    // MULTIPLE PHOTOS GALLERY MANAGEMENT ACTIONS
    // ==========================================

    /**
     * Display gallery management interface for a project.
     */
    public function gallery(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $db = Database::getConnection();

            // Fetch Project details
            $projStmt = $db->prepare("SELECT id, title FROM `projects` WHERE `id` = ? LIMIT 1");
            $projStmt->execute([$id]);
            $project = $projStmt->fetch();

            if (!$project) {
                $_SESSION['flash']['error'] = 'Proyek tidak ditemukan.';
                $this->redirect('/admin/projects');
            }

            // Fetch all associated gallery media
            $mediaStmt = $db->prepare("SELECT * FROM `project_media` WHERE `project_id` = ? ORDER BY `sort_order` ASC, `created_at` DESC");
            $mediaStmt->execute([$id]);
            $mediaItems = $mediaStmt->fetchAll();

            $this->render('admin/projects/gallery', [
                'title'      => 'Galeri Proyek: ' . $project['title'],
                'project'    => $project,
                'mediaItems' => $mediaItems,
            ]);

        } catch (Exception $e) {
            error_log("Gallery load failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal memuat galeri proyek.';
            $this->redirect('/admin/projects');
        }
    }

    /**
     * Upload and store a new photo in the project's gallery.
     */
    public function storeGallery(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        $title       = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $altText     = trim($_POST['alt_text'] ?? '');
        $sortOrder   = (int)($_POST['sort_order'] ?? 0);
        $isActive    = isset($_POST['is_active']) ? 1 : 0;

        if (empty($title) || empty($description)) {
            $_SESSION['flash']['error'] = 'Judul foto dan Deskripsi detail wajib diisi.';
            $this->redirect("/admin/projects/gallery/{$id}");
        }

        if (!isset($_FILES['media_file']) || $_FILES['media_file']['error'] === UPLOAD_ERR_NO_FILE) {
            $_SESSION['flash']['error'] = 'Berkas foto wajib dipilih.';
            $this->redirect("/admin/projects/gallery/{$id}");
        }

        try {
            // Upload picture
            $uploadResult = UploadService::uploadImage($_FILES['media_file'], 'projects/gallery', 1000, 1000, true);
            $filePath = $uploadResult['image_path'];

            $db = Database::getConnection();
            $stmt = $db->prepare("
                INSERT INTO `project_media` (
                    `project_id`, `media_type`, `file_path`, `title`, `description`, `alt_text`, `sort_order`, `is_active`
                ) VALUES (?, 'image', ?, ?, ?, ?, ?, ?)
            ");
            $stmt->execute([
                $id,
                $filePath,
                $title,
                $description,
                $altText ?: $title, // Fallback to title
                $sortOrder,
                $isActive
            ]);

            $_SESSION['flash']['success'] = 'Foto dokumentasi baru berhasil ditambahkan ke galeri!';

        } catch (Exception $e) {
            error_log("Gallery store failure: " . $e->getMessage());
            if (isset($filePath)) {
                UploadService::delete($filePath);
                $thumb = str_replace('projects/gallery/', 'projects/gallery/thumbs/thumb_', $filePath);
                UploadService::delete($thumb);
            }
            $_SESSION['flash']['error'] = 'Gagal menambahkan foto: ' . $e->getMessage();
        }

        $this->redirect("/admin/projects/gallery/{$id}");
    }

    /**
     * Edit / Update gallery photo metadata.
     */
    public function updateGallery(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        $title       = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $altText     = trim($_POST['alt_text'] ?? '');
        $sortOrder   = (int)($_POST['sort_order'] ?? 0);
        $isActive    = isset($_POST['is_active']) ? 1 : 0;
        $projectId   = $_POST['project_id'] ?? '';

        if (empty($projectId)) {
            $_SESSION['flash']['error'] = 'Parameter tidak valid.';
            $this->redirect('/admin/projects');
        }

        if (empty($title) || empty($description)) {
            $_SESSION['flash']['error'] = 'Judul foto dan Deskripsi detail wajib diisi.';
            $this->redirect("/admin/projects/gallery/{$projectId}");
        }

        try {
            $db = Database::getConnection();

            // Fetch current media item to handle image file replacement if uploaded
            $stmtFetch = $db->prepare("SELECT file_path FROM `project_media` WHERE `id` = ? LIMIT 1");
            $stmtFetch->execute([$id]);
            $currentMedia = $stmtFetch->fetch();

            if (!$currentMedia) {
                $_SESSION['flash']['error'] = 'Data media tidak ditemukan.';
                $this->redirect("/admin/projects/gallery/{$projectId}");
            }

            $filePath = $currentMedia['file_path'];
            $newFileUploaded = false;

            // Handle replacement file if provided
            if (isset($_FILES['media_file']) && $_FILES['media_file']['error'] !== UPLOAD_ERR_NO_FILE) {
                $uploadResult = UploadService::uploadImage($_FILES['media_file'], 'projects/gallery', 1000, 1000, true);
                $newFilePath = $uploadResult['image_path'];
                $newFileUploaded = true;
            }

            $activeFilePath = $newFileUploaded ? $newFilePath : $filePath;

            $updateStmt = $db->prepare("
                UPDATE `project_media` SET 
                    `file_path` = ?,
                    `title` = ?,
                    `description` = ?,
                    `alt_text` = ?,
                    `sort_order` = ?,
                    `is_active` = ? 
                WHERE `id` = ?
            ");
            $updateStmt->execute([
                $activeFilePath,
                $title,
                $description,
                $altText ?: $title,
                $sortOrder,
                $isActive,
                $id
            ]);

            // If replacement was successful, clean up old file from server
            if ($newFileUploaded) {
                UploadService::delete($filePath);
                $oldThumb = str_replace('projects/gallery/', 'projects/gallery/thumbs/thumb_', $filePath);
                UploadService::delete($oldThumb);
            }

            $_SESSION['flash']['success'] = 'Metadata foto galeri berhasil diperbarui!';

        } catch (Exception $e) {
            error_log("Gallery update failure: " . $e->getMessage());
            if (isset($newFilePath)) {
                UploadService::delete($newFilePath);
                $newThumb = str_replace('projects/gallery/', 'projects/gallery/thumbs/thumb_', $newFilePath);
                UploadService::delete($newThumb);
            }
            $_SESSION['flash']['error'] = 'Gagal memperbarui foto galeri: ' . $e->getMessage();
        }

        $this->redirect("/admin/projects/gallery/{$projectId}");
    }

    /**
     * Delete photo from gallery.
     */
    public function deleteGallery(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        $projectId = $_POST['project_id'] ?? '';

        if (empty($projectId)) {
            $_SESSION['flash']['error'] = 'Parameter tidak valid.';
            $this->redirect('/admin/projects');
        }

        try {
            $db = Database::getConnection();

            // Fetch media item details
            $stmtFetch = $db->prepare("SELECT file_path FROM `project_media` WHERE `id` = ? LIMIT 1");
            $stmtFetch->execute([$id]);
            $media = $stmtFetch->fetch();

            if (!$media) {
                $_SESSION['flash']['error'] = 'Foto tidak ditemukan.';
                $this->redirect("/admin/projects/gallery/{$projectId}");
            }

            // Delete from database
            $deleteStmt = $db->prepare("DELETE FROM `project_media` WHERE `id` = ?");
            $deleteStmt->execute([$id]);

            // Delete physical files
            UploadService::delete($media['file_path']);
            $thumbPath = str_replace('projects/gallery/', 'projects/gallery/thumbs/thumb_', $media['file_path']);
            UploadService::delete($thumbPath);

            $_SESSION['flash']['success'] = 'Foto berhasil dihapus dari galeri.';

        } catch (Exception $e) {
            error_log("Gallery delete failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Terjadi kesalahan saat menghapus foto galeri.';
        }

        $this->redirect("/admin/projects/gallery/{$projectId}");
    }

    /**
     * Verify CSRF token.
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
