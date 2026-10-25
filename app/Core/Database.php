<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;
use RuntimeException;

class Database
{
    private static ?PDO $instance = null;

    /**
     * Get the PDO database connection instance (Singleton).
     *
     * @return PDO
     * @throws RuntimeException
     */
    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
            $port = $_ENV['DB_PORT'] ?? '3306';
            $db   = $_ENV['DB_DATABASE'] ?? 'porto_ikhsan';
            $user = $_ENV['DB_USERNAME'] ?? 'root';
            $pass = $_ENV['DB_PASSWORD'] ?? '';
            $charset = 'utf8mb4';

            $dsn = "mysql:host={$host};port={$port};dbname={$db};charset={$charset}";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ];

            try {
                self::$instance = new PDO($dsn, $user, $pass, $options);
            } catch (PDOException $e) {
                // In production, we log this and show a generic message.
                // Log error safely:
                error_log("Database Connection Failure: " . $e->getMessage());
                
                $env = $_ENV['APP_ENV'] ?? 'production';
                if ($env === 'local') {
                    throw new RuntimeException("Database Connection failed: " . $e->getMessage(), (int)$e->getCode(), $e);
                } else {
                    throw new RuntimeException("Database connection error. Please try again later.");
                }
            }
        }

        return self::$instance;
    }

    /**
     * Prevent cloning or unserializing of Singleton.
     */
    private function __construct() {}
    private function __clone() {}
    public function __wakeup() {
        throw new \Exception("Cannot unserialize singleton");
    }
}
