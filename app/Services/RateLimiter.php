<?php

declare(strict_types=1);

namespace App\Services;

class RateLimiter
{
    private static string $filePath = __DIR__ . '/../../storage/logs/rate_limit.json';
    private static string $passwordFilePath = __DIR__ . '/../../storage/logs/password_rate_limit.json';

    public static function consumePasswordAttempt(int $adminId, string $ip): bool
    {
        $file = fopen(self::$passwordFilePath, 'c+');
        if ($file === false) {
            throw new \RuntimeException('Limiter unavailable.');
        }

        try {
            if (!flock($file, LOCK_EX)) {
                throw new \RuntimeException('Limiter unavailable.');
            }
            $content = stream_get_contents($file);
            $data = $content === '' ? [] : json_decode($content, true, 512, JSON_THROW_ON_ERROR);
            if (!is_array($data)) {
                throw new \RuntimeException('Limiter unavailable.');
            }
            $now = time();
            foreach ($data as $key => $entry) {
                if (!is_array($entry) || !isset($entry['expires'], $entry['attempts'])) {
                    throw new \RuntimeException('Limiter unavailable.');
                }
                if ($entry['expires'] <= $now) {
                    unset($data[$key]);
                }
            }
            $limits = ['account_' . $adminId => 5, 'ip_' . hash('sha256', $ip) => 20];
            foreach ($limits as $key => $limit) {
                if (($data[$key]['attempts'] ?? 0) >= $limit) {
                    return false;
                }
            }
            foreach ($limits as $key => $limit) {
                $data[$key] ??= ['attempts' => 0, 'expires' => $now + 900];
                $data[$key]['attempts']++;
            }
            $encoded = json_encode($data, JSON_THROW_ON_ERROR);
            if (!rewind($file) || !ftruncate($file, 0) || fwrite($file, $encoded) !== strlen($encoded) || !fflush($file)) {
                throw new \RuntimeException('Limiter unavailable.');
            }
            return true;
        } finally {
            flock($file, LOCK_UN);
            fclose($file);
        }
    }

    /**
     * Check if the IP is currently rate limited.
     *
     * @param string $key Unique key for rate limiting (e.g., 'login_' . $ip)
     * @param int $maxAttempts Maximum allowed attempts
     * @param int $decaySeconds Lockout duration in seconds (e.g., 900 for 15 mins)
     * @return bool True if allowed, false if blocked
     */
    public static function check(string $key, int $maxAttempts = 5, int $decaySeconds = 900): bool
    {
        $data = self::readData();
        $now = time();

        if (isset($data[$key])) {
            $entry = $data[$key];
            
            // Check if block has expired
            if ($now - $entry['last_attempt'] > $decaySeconds) {
                // Expired, clear and allow
                self::clear($key);
                return true;
            }

            // Blocked if attempts exceeded max
            if ($entry['attempts'] >= $maxAttempts) {
                return false;
            }
        }

        return true;
    }

    /**
     * Record a failed attempt.
     */
    public static function hit(string $key): void
    {
        $data = self::readData();
        $now = time();

        if (!isset($data[$key])) {
            $data[$key] = [
                'attempts' => 1,
                'last_attempt' => $now
            ];
        } else {
            $data[$key]['attempts']++;
            $data[$key]['last_attempt'] = $now;
        }

        self::writeData($data);
    }

    /**
     * Get remaining time in seconds before key is unlocked.
     */
    public static function getDecayTimeRemaining(string $key, int $decaySeconds = 900): int
    {
        $data = self::readData();
        if (!isset($data[$key])) {
            return 0;
        }

        $elapsed = time() - $data[$key]['last_attempt'];
        $remaining = $decaySeconds - $elapsed;

        return max(0, $remaining);
    }

    /**
     * Clear rate limit for a key (on success).
     */
    public static function clear(string $key): void
    {
        $data = self::readData();
        if (isset($data[$key])) {
            unset($data[$key]);
            self::writeData($data);
        }
    }

    /**
     * Read data from rate limit JSON.
     */
    private static function readData(): array
    {
        if (!file_exists(self::$filePath)) {
            return [];
        }

        $content = file_get_contents(self::$filePath);
        if (empty($content)) {
            return [];
        }

        $data = json_decode($content, true);
        return is_array($data) ? $data : [];
    }

    /**
     * Write data to rate limit JSON.
     */
    private static function writeData(array $data): void
    {
        // Keep logs clean by removing entries older than 24 hours
        $now = time();
        $cleanedData = [];
        foreach ($data as $key => $entry) {
            if ($now - $entry['last_attempt'] < 86400) {
                $cleanedData[$key] = $entry;
            }
        }

        file_put_contents(self::$filePath, json_encode($cleanedData, JSON_PRETTY_PRINT));
    }
}
