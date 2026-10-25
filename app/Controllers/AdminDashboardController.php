<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Database;
use PDO;

class AdminDashboardController extends BaseController
{
    /**
     * Show the admin dashboard index.
     */
    public function index(): void
    {
        try {
            $db = Database::getConnection();

            // 1. Fetch counts
            $totalProjects = (int)$db->query("SELECT COUNT(*) FROM `projects`")->fetchColumn();
            $totalMedia    = (int)$db->query("SELECT COUNT(*) FROM `project_media`")->fetchColumn();
            $totalMessages = (int)$db->query("SELECT COUNT(*) FROM `messages`")->fetchColumn();
            $unreadMessages = (int)$db->query("SELECT COUNT(*) FROM `messages` WHERE `status` = 'unread'")->fetchColumn();

            // 2. Fetch last content update timestamp
            // Query maximum updated_at across projects and profiles
            $stmt = $db->query("
                SELECT MAX(updated_time) FROM (
                    SELECT MAX(updated_at) as updated_time FROM `projects`
                    UNION
                    SELECT MAX(updated_at) as updated_time FROM `profiles`
                    UNION
                    SELECT MAX(updated_at) as updated_time FROM `skills`
                ) as updates
            ");
            $lastUpdateRaw = $stmt->fetchColumn();
            $lastUpdate = $lastUpdateRaw ? date('d-m-Y H:i', strtotime($lastUpdateRaw)) : 'Belum ada';

            // 3. Fetch latest messages (limit 5)
            $latestMessagesStmt = $db->query("
                SELECT * FROM `messages` 
                ORDER BY `created_at` DESC 
                LIMIT 5
            ");
            $latestMessages = $latestMessagesStmt->fetchAll();

            $this->render('admin/dashboard', [
                'title'          => 'Dashboard Ringkasan',
                'totalProjects'  => $totalProjects,
                'totalMedia'     => $totalMedia,
                'totalMessages'  => $totalMessages,
                'unreadMessages' => $unreadMessages,
                'lastUpdate'     => $lastUpdate,
                'latestMessages' => $latestMessages,
            ]);

        } catch (\Exception $e) {
            error_log("Dashboard Error: " . $e->getMessage());
            $this->render('admin/dashboard', [
                'title'          => 'Dashboard Ringkasan',
                'totalProjects'  => 0,
                'totalMedia'     => 0,
                'totalMessages'  => 0,
                'unreadMessages' => 0,
                'lastUpdate'     => 'Error sistem',
                'latestMessages' => [],
            ]);
        }
    }
}
