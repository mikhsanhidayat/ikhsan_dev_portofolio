<?php

declare(strict_types=1);

namespace App\Controllers;

use RuntimeException;

abstract class BaseController
{
    /**
     * Render a view file and inject data.
     *
     * @param string $view e.g. 'public/home' or 'admin/dashboard'
     * @param array $data Data variables to be extracted in the view
     */
    protected function render(string $view, array $data = []): void
    {
        // Add common helper functions to be available in views
        // for escaping and CSRF.
        
        $viewFile = dirname(__DIR__, 2) . '/resources/views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            throw new RuntimeException("View file '{$view}' not found at path: {$viewFile}");
        }

        // Extract data to make them available as variables in the view
        extract($data);

        // Include the view file
        require $viewFile;
    }

    /**
     * Send a JSON response.
     */
    protected function json(mixed $data, int $statusCode = 200): void
    {
        header('Content-Type: application/json; charset=utf-8');
        http_response_code($statusCode);
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Redirect to another URL.
     */
    protected function redirect(string $url): void
    {
        header("Location: {$url}");
        exit;
    }
}
