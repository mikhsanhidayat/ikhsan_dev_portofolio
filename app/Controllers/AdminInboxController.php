<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use Exception;
use PDO;

class AdminInboxController extends BaseController
{
    /**
     * List all messages with filters.
     */
    public function index(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $search = trim($_GET['search'] ?? '');
        $status = trim($_GET['status'] ?? 'unread');

        // Validate status filter
        if (!in_array($status, ['unread', 'read', 'archived', 'all'])) {
            $status = 'unread';
        }

        try {
            $db = Database::getConnection();

            $query = "SELECT * FROM `messages` WHERE 1=1";
            $params = [];

            if (!empty($search)) {
                $query .= " AND (`name` LIKE ? OR `email` LIKE ? OR `subject` LIKE ? OR `message` LIKE ?)";
                $searchParam = "%{$search}%";
                $params[] = $searchParam;
                $params[] = $searchParam;
                $params[] = $searchParam;
                $params[] = $searchParam;
            }

            if ($status !== 'all') {
                $query .= " AND `status` = ?";
                $params[] = $status;
            }

            $query .= " ORDER BY `created_at` DESC";

            $stmt = $db->prepare($query);
            $stmt->execute($params);
            $messages = $stmt->fetchAll();

            $this->render('admin/inbox', [
                'title'          => 'Kotak Pesan Masuk (Inbox)',
                'messages'       => $messages,
                'currentStatus'  => $status,
                'currentSearch'  => $search,
            ]);

        } catch (Exception $e) {
            error_log("Inbox load failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal memuat pesan masuk.';
            $this->redirect('/admin/dashboard');
        }
    }

    /**
     * Get a specific message detail (returns JSON) and marks it as read.
     */
    public function detail(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        try {
            $db = Database::getConnection();

            // Fetch message
            $stmt = $db->prepare("SELECT * FROM `messages` WHERE `id` = ? LIMIT 1");
            $stmt->execute([$id]);
            $msg = $stmt->fetch();

            if (!$msg) {
                http_response_code(404);
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'message' => 'Pesan tidak ditemukan.']);
                exit;
            }

            // If message is unread, mark it as read
            if ($msg['status'] === 'unread') {
                $updateStmt = $db->prepare("UPDATE `messages` SET `status` = 'read' WHERE `id` = ?");
                $updateStmt->execute([$id]);
                $msg['status'] = 'read'; // reflect in response
            }

            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => true, 'data' => $msg]);
            exit;

        } catch (Exception $e) {
            error_log("Inbox detail failure: " . $e->getMessage());
            http_response_code(500);
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Terjadi kesalahan sistem.']);
            exit;
        }
    }

    /**
     * Mark message as read/unread manually.
     */
    public function toggleRead(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        $targetStatus = trim($_POST['status'] ?? 'read');
        if (!in_array($targetStatus, ['read', 'unread'])) {
            $targetStatus = 'read';
        }

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE `messages` SET `status` = ? WHERE `id` = ?");
            $stmt->execute([$targetStatus, $id]);

            $_SESSION['flash']['success'] = 'Status pesan berhasil diperbarui!';
        } catch (Exception $e) {
            error_log("Inbox status update error: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal memperbarui status pesan.';
        }

        $this->redirect('/admin/inbox');
    }

    /**
     * Archive message.
     */
    public function archive(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("UPDATE `messages` SET `status` = 'archived' WHERE `id` = ?");
            $stmt->execute([$id]);

            $_SESSION['flash']['success'] = 'Pesan berhasil diarsipkan!';
        } catch (Exception $e) {
            error_log("Inbox archive failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal mengarsipkan pesan.';
        }

        $this->redirect('/admin/inbox');
    }

    /**
     * Delete message permanently.
     */
    public function delete(string $id): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->verifyCsrf();

        try {
            $db = Database::getConnection();
            $stmt = $db->prepare("DELETE FROM `messages` WHERE `id` = ?");
            $stmt->execute([$id]);

            $_SESSION['flash']['success'] = 'Pesan berhasil dihapus secara permanen!';
        } catch (Exception $e) {
            error_log("Inbox delete failure: " . $e->getMessage());
            $_SESSION['flash']['error'] = 'Gagal menghapus pesan.';
        }

        $this->redirect('/admin/inbox');
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
