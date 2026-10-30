<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use Exception;
use PDO;

class HomeController extends BaseController
{
    /**
     * Show the landing page with all portfolio data.
     */
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $db = Database::getConnection();

            // 1. Fetch Profile
            $profileStmt = $db->query("SELECT * FROM `profiles` LIMIT 1");
            $profile = $profileStmt->fetch();

            // 2. Fetch Active CV
            $cvStmt = $db->query("SELECT file_path, original_name FROM `documents` WHERE `document_type` = 'cv' AND `is_active` = 1 LIMIT 1");
            $cv = $cvStmt->fetch();

            // 3. Fetch Skills grouped by Category
            $skillsStmt = $db->query("SELECT * FROM `skills` WHERE `is_active` = 1 ORDER BY `category` ASC, `sort_order` ASC");
            $skillsRaw = $skillsStmt->fetchAll();
            $skills = [];
            foreach ($skillsRaw as $s) {
                $skills[$s['category']][] = $s;
            }

            // 4. Fetch Educations
            $eduStmt = $db->query("SELECT * FROM `educations` WHERE `is_active` = 1 ORDER BY `sort_order` ASC, `start_year` DESC");
            $educations = $eduStmt->fetchAll();

            // 5. Fetch Experiences
            $expStmt = $db->query("SELECT * FROM `experiences` WHERE `is_active` = 1 ORDER BY `sort_order` ASC, `start_date` DESC");
            $experiences = $expStmt->fetchAll();

            // 6. Fetch Project Categories
            $catStmt = $db->query("SELECT * FROM `project_categories` WHERE `is_active` = 1 ORDER BY `name` ASC");
            $categories = $catStmt->fetchAll();

            // 7. Fetch Technologies
            $techStmt = $db->query("SELECT * FROM `technologies` WHERE `is_active` = 1 ORDER BY `name` ASC");
            $technologies = $techStmt->fetchAll();

            // 8. Fetch Published Projects
            $projStmt = $db->query("
                SELECT p.*, c.name as category_name 
                FROM `projects` p
                LEFT JOIN `project_categories` c ON p.category_id = c.id
                WHERE p.publication_status = 'published'
                ORDER BY p.sort_order ASC, p.created_at DESC
            ");
            $projects = $projStmt->fetchAll();

            // For each project, fetch its associated technologies
            foreach ($projects as &$p) {
                $pTechStmt = $db->prepare("
                    SELECT t.* 
                    FROM `technologies` t
                    JOIN `project_technologies` pt ON t.id = pt.technology_id
                    WHERE pt.project_id = ? AND t.is_active = 1
                ");
                $pTechStmt->execute([$p['id']]);
                $p['technologies'] = $pTechStmt->fetchAll();
            }
            unset($p);

            // 9. Fetch Settings
            $settingsStmt = $db->query("SELECT `key`, `value` FROM `settings`");
            $settingsRaw = $settingsStmt->fetchAll();
            $settings = [];
            foreach ($settingsRaw as $set) {
                $settings[$set['key']] = $set['value'];
            }

            // Render view
            $this->render('public/home', [
                'title'        => $settings['meta_title'] ?? 'Muhamad Ikhsan Hidayat | Fullstack Developer Portfolio',
                'profile'      => $profile,
                'cv'           => $cv,
                'skills'       => $skills,
                'educations'   => $educations,
                'experiences'  => $experiences,
                'categories'   => $categories,
                'technologies' => $technologies,
                'projects'     => $projects,
                'settings'     => $settings,
            ]);

        } catch (Exception $e) {
            error_log("Landing page load error: " . $e->getMessage());
            die("Terjadi kesalahan sistem saat memuat website.");
        }
    }

    /**
     * Show project details by slug.
     */
    public function projectDetail(string $slug): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $db = Database::getConnection();

            // 1. Fetch Project by Slug
            $projStmt = $db->prepare("
                SELECT p.*, c.name as category_name 
                FROM `projects` p
                LEFT JOIN `project_categories` c ON p.category_id = c.id
                WHERE p.slug = ? AND p.publication_status = 'published'
                LIMIT 1
            ");
            $projStmt->execute([$slug]);
            $project = $projStmt->fetch();

            if (!$project) {
                $this->render404();
                return;
            }

            // 2. Fetch Project Technologies
            $techStmt = $db->prepare("
                SELECT t.* 
                FROM `technologies` t
                JOIN `project_technologies` pt ON t.id = pt.technology_id
                WHERE pt.project_id = ? AND t.is_active = 1
            ");
            $techStmt->execute([$project['id']]);
            $projectTechnologies = $techStmt->fetchAll();

            // 3. Fetch Project Media (Gallery)
            $mediaStmt = $db->prepare("
                SELECT * FROM `project_media` 
                WHERE `project_id` = ? AND `is_active` = 1 
                ORDER BY `sort_order` ASC, `created_at` DESC
            ");
            $mediaStmt->execute([$project['id']]);
            $projectMedia = $mediaStmt->fetchAll();

            // 4. Fetch Settings
            $settingsStmt = $db->query("SELECT `key`, `value` FROM `settings`");
            $settingsRaw = $settingsStmt->fetchAll();
            $settings = [];
            foreach ($settingsRaw as $set) {
                $settings[$set['key']] = $set['value'];
            }

            // 5. Fetch Profile (for footer/header)
            $profileStmt = $db->query("SELECT * FROM `profiles` LIMIT 1");
            $profile = $profileStmt->fetch();

            $this->render('public/project_detail', [
                'title'        => $project['title'] . ' | Detail Proyek',
                'profile'      => $profile,
                'project'      => $project,
                'technologies' => $projectTechnologies,
                'mediaItems'   => $projectMedia,
                'settings'     => $settings,
            ]);

        } catch (Exception $e) {
            error_log("Project detail load error (slug: {$slug}): " . $e->getMessage());
            die("Terjadi kesalahan sistem saat memuat detail proyek.");
        }
    }

    /**
     * Render a custom 404 page.
     */
    private function render404(): void
    {
        http_response_code(404);
        $this->render('public/404', [
            'title' => 'Halaman Tidak Ditemukan - 404',
        ]);
    }

    /**
     * Handle public contact form submission.
     */
    public function submitContact(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // 1. Anti-spam Honeypot Check
        $honeypot = $_POST['website'] ?? '';
        if (!empty($honeypot)) {
            $this->respond([
                'success' => true,
                'message' => 'Pesan Anda berhasil dikirim! Terima kasih.'
            ]);
            return;
        }

        // 2. CSRF check
        $csrfToken = $_POST['csrf_token'] ?? '';
        if (empty($csrfToken) || $csrfToken !== ($_SESSION['csrf_token'] ?? '')) {
            $this->respond([
                'success' => false,
                'message' => 'Token CSRF tidak valid. Silakan muat ulang halaman.'
            ], 403);
            return;
        }

        // 3. Validation
        $name    = trim($_POST['name'] ?? '');
        $email   = trim($_POST['email'] ?? '');
        $subject = trim($_POST['subject'] ?? '');
        $message = trim($_POST['message'] ?? '');

        if (empty($name) || empty($email) || empty($subject) || empty($message)) {
            $this->respond([
                'success' => false,
                'message' => 'Semua kolom formulir wajib diisi.'
            ], 400);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->respond([
                'success' => false,
                'message' => 'Format alamat email tidak valid.'
            ], 400);
            return;
        }

        if (strlen($name) < 3) {
            $this->respond([
                'success' => false,
                'message' => 'Nama minimal terdiri dari 3 karakter.'
            ], 400);
            return;
        }

        if (strlen($subject) < 5) {
            $this->respond([
                'success' => false,
                'message' => 'Subjek minimal terdiri dari 5 karakter.'
            ], 400);
            return;
        }

        if (strlen($message) < 15) {
            $this->respond([
                'success' => false,
                'message' => 'Pesan minimal terdiri dari 15 karakter.'
            ], 400);
            return;
        }

        // 4. Save to Database
        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("
                INSERT INTO `messages` (`name`, `email`, `subject`, `message`, `status`, `ip_address`, `user_agent`) 
                VALUES (?, ?, ?, ?, 'unread', ?, ?)
            ");

            $ipAddress = $_SERVER['REMOTE_ADDR'] ?? 'Unknown';
            $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'Unknown';

            $stmt->execute([$name, $email, $subject, $message, $ipAddress, $userAgent]);

            $this->respond([
                'success' => true,
                'message' => 'Pesan Anda berhasil dikirim! Kami akan menghubungi Anda segera.'
            ]);

        } catch (Exception $e) {
            error_log("Contact submit failure: " . $e->getMessage());
            $this->respond([
                'success' => false,
                'message' => 'Terjadi kesalahan sistem saat mengirim pesan. Silakan coba sesaat lagi.'
            ], 500);
        }
    }

    /**
     * Respond with JSON or redirect.
     */
    private function respond(array $data, int $statusCode = 200): void
    {
        $isAjax = (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest')
            || (str_contains($_SERVER['HTTP_ACCEPT'] ?? '', 'application/json'));

        if ($isAjax) {
            http_response_code($statusCode);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode($data);
            exit;
        }

        // For traditional form post fallback
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($data['success']) {
            $_SESSION['flash']['success'] = $data['message'];
        } else {
            $_SESSION['flash']['error'] = $data['message'];
        }

        $this->redirect('/');
    }

    /**
     * Generate dynamic XML sitemap.
     */
    public function sitemap(): void
    {
        try {
            $db = Database::getConnection();
            $stmt = $db->query("
                SELECT slug, created_at 
                FROM `projects` 
                WHERE `publication_status` = 'published' 
                ORDER BY `created_at` DESC
            ");
            $projects = $stmt->fetchAll();

            $baseUrl = 'http://' . ($_SERVER['HTTP_HOST'] ?? 'localhost:8000');

            header("Content-Type: text/xml; charset=utf-8");
            
            echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
            echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\n";
            
            // Homepage
            echo "  <url>\n";
            echo "    <loc>{$baseUrl}/</loc>\n";
            echo "    <changefreq>daily</changefreq>\n";
            echo "    <priority>1.0</priority>\n";
            echo "  </url>\n";

            // Projects sitemaps
            foreach ($projects as $proj) {
                $lastmod = date('c', strtotime($proj['created_at']));
                echo "  <url>\n";
                echo "    <loc>{$baseUrl}/project/" . e($proj['slug']) . "</loc>\n";
                echo "    <lastmod>{$lastmod}</lastmod>\n";
                echo "    <changefreq>weekly</changefreq>\n";
                echo "    <priority>0.8</priority>\n";
                echo "  </url>\n";
            }

            echo '</urlset>' . "\n";
            exit;

        } catch (Exception $e) {
            error_log("Sitemap generation failure: " . $e->getMessage());
            http_response_code(500);
            echo "Gagal membuat sitemap.";
            exit;
        }
    }
}
