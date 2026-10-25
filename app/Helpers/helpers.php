<?php

declare(strict_types=1);

if (!function_exists('e')) {
    /**
     * Escape HTML entities to prevent XSS.
     */
    function e(?string $value): string
    {
        return htmlspecialchars($value ?? '', ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}

if (!function_exists('csrf_token')) {
    /**
     * Get or generate CSRF token from session.
     */
    function csrf_token(): string
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        return $_SESSION['csrf_token'];
    }
}

if (!function_exists('csrf_field')) {
    /**
     * Generate HTML input field for CSRF.
     */
    function csrf_field(): string
    {
        return '<input type="hidden" name="csrf_token" value="' . e(csrf_token()) . '">';
    }
}

if (!function_exists('old')) {
    /**
     * Get old input value.
     */
    function old(string $key, mixed $default = ''): mixed
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return $_SESSION['old_input'][$key] ?? $default;
    }
}

if (!function_exists('route')) {
    /**
     * Generate full URL path.
     */
    function route(string $path): string
    {
        $baseUrl = rtrim($_ENV['APP_URL'] ?? 'http://localhost:8000', '/');
        return $baseUrl . '/' . ltrim($path, '/');
    }
}

if (!function_exists('session_flash')) {
    /**
     * Get or set a session flash message.
     */
    function session_flash(string $key, mixed $value = null): mixed
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($value !== null) {
            $_SESSION['flash'][$key] = $value;
            return null;
        }

        if (isset($_SESSION['flash'][$key])) {
            $msg = $_SESSION['flash'][$key];
            unset($_SESSION['flash'][$key]);
            return $msg;
        }

        return null;
    }
}

if (!function_exists('session_has_flash')) {
    /**
     * Check if a flash message exists.
     */
    function session_has_flash(string $key): bool
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        return isset($_SESSION['flash'][$key]);
    }
}

if (!function_exists('generate_slug')) {
    /**
     * Generate an SEO-friendly slug.
     */
    function generate_slug(string $text): string
    {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        return empty($text) ? 'n-a' : $text;
    }
}

if (!function_exists('public_path')) {
    /**
     * Get the absolute path to the public folder.
     */
    function public_path(string $path = ''): string
    {
        $basePath = dirname(__DIR__, 2) . '/public';
        return $basePath . ($path ? '/' . ltrim($path, '/') : '');
    }
}

if (!function_exists('get_google_maps_embed_url')) {
    /**
     * Clean and parse any Google Maps URL (normal share link, iframe code, direct coordinates)
     * or a plain text address / city query and convert it into a valid embed source URL.
     */
    function get_google_maps_embed_url(string $url): string
    {
        $url = trim($url);
        if (empty($url)) {
            return '';
        }
        
        // If it's a plain text address (doesn't start with http/https and is not an iframe tag)
        if (strpos($url, 'http://') !== 0 && strpos($url, 'https://') !== 0 && strpos($url, '<iframe') === false) {
            return "https://maps.google.com/maps?q=" . urlencode($url) . "&t=&z=14&ie=UTF8&iwloc=&output=embed";
        }
        
        // 1. If it's an iframe tag, extract the src URL
        if (preg_match('/src="([^"]+)"/i', $url, $iframeMatches)) {
            $url = $iframeMatches[1];
        }
        
        // 2. If it's already an embed URL or dynamic embed query, return it
        if (strpos($url, '/maps/embed') !== false || strpos($url, 'output=embed') !== false) {
            return $url;
        }
        
        // 3. Extract coordinates if they exist (e.g. @-7.1678316,108.0936289)
        if (preg_match('/@(-?\d+\.\d+),(-?\d+\.\d+)/', $url, $coordMatches)) {
            $lat = $coordMatches[1];
            $lng = $coordMatches[2];
            return "https://maps.google.com/maps?q={$lat},{$lng}&t=&z=14&ie=UTF8&iwloc=&output=embed";
        }
        
        // 4. Extract place name (e.g. /maps/place/Kec.+Ciawi...)
        if (preg_match('/\/maps\/place\/([^\/]+)/', $url, $placeMatches)) {
            $place = $placeMatches[1];
            return "https://maps.google.com/maps?q={$place}&t=&z=14&ie=UTF8&iwloc=&output=embed";
        }
        
        // 5. Fallback: Parse query q parameter if exists
        $parsedUrl = parse_url($url);
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $queryParams);
            if (isset($queryParams['q'])) {
                return "https://maps.google.com/maps?q=" . urlencode($queryParams['q']) . "&t=&z=14&ie=UTF8&iwloc=&output=embed";
            }
        }
        
        return $url;
    }
}

