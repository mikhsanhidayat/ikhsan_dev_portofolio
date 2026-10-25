<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

class Router
{
    private array $routes = [];
    private string $currentPrefix = '';
    private array $currentGroupMiddlewares = [];

    /**
     * Define a group of routes sharing a prefix and/or middlewares.
     */
    public function group(string $prefix, array $middlewares, callable $callback): void
    {
        $previousPrefix = $this->currentPrefix;
        $previousMiddlewares = $this->currentGroupMiddlewares;

        $this->currentPrefix = $previousPrefix . $prefix;
        $this->currentGroupMiddlewares = array_merge($previousMiddlewares, $middlewares);

        $callback($this);

        $this->currentPrefix = $previousPrefix;
        $this->currentGroupMiddlewares = $previousMiddlewares;
    }

    /**
     * Add a GET route.
     */
    public function get(string $path, array $handler, array $middlewares = []): void
    {
        $this->addRoute('GET', $path, $handler, $middlewares);
    }

    /**
     * Add a POST route.
     */
    public function post(string $path, array $handler, array $middlewares = []): void
    {
        $this->addRoute('POST', $path, $handler, $middlewares);
    }

    /**
     * Register a route internally.
     */
    private function addRoute(string $method, string $path, array $handler, array $middlewares): void
    {
        $fullPath = $this->currentPrefix . $path;
        // Trim trailing slashes except for root
        if ($fullPath !== '/') {
            $fullPath = rtrim($fullPath, '/');
        }

        $allMiddlewares = array_merge($this->currentGroupMiddlewares, $middlewares);

        $this->routes[] = [
            'method'      => $method,
            'path'        => $fullPath,
            'handler'     => $handler,
            'middlewares' => $allMiddlewares,
        ];
    }

    /**
     * Dispatch the current HTTP request.
     */
    public function dispatch(string $requestUri, string $requestMethod): void
    {
        // Parse URI to remove query string
        $parsedUrl = parse_url($requestUri);
        $path = $parsedUrl['path'] ?? '/';
        
        if ($path !== '/') {
            $path = rtrim($path, '/');
        }

        $requestMethod = strtoupper($requestMethod);

        foreach ($this->routes as $route) {
            if ($route['method'] !== $requestMethod) {
                continue;
            }

            // Convert {parameter} to regex capture groups
            // e.g. /project/{slug} -> ^/project/(?P<slug>[^/]+)$
            $pattern = preg_replace('/\{([a-zA-Z0-9_-]+)\}/', '(?P<$1>[^/]+)', $route['path']);
            $pattern = '#^' . $pattern . '$#';

            if (preg_match($pattern, $path, $matches)) {
                // Extract named parameter matches
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);

                // Run middlewares
                foreach ($route['middlewares'] as $middlewareClass) {
                    if (class_exists($middlewareClass)) {
                        $middleware = new $middlewareClass();
                        // Middlewares should throw a RedirectException or render an error if unauthorized
                        $middleware->handle();
                    } else {
                        throw new RuntimeException("Middleware class {$middlewareClass} not found.");
                    }
                }

                // Call the controller method
                [$controllerClass, $methodName] = $route['handler'];

                if (class_exists($controllerClass)) {
                    $controller = new $controllerClass();
                    if (method_exists($controller, $methodName)) {
                        // Invoke controller action with parameters
                        call_user_func_array([$controller, $methodName], $params);
                        return;
                    }
                    throw new RuntimeException("Method {$methodName} not found in controller class {$controllerClass}.");
                }
                throw new RuntimeException("Controller class {$controllerClass} not found.");
            }
        }

        // No route matched
        $this->sendNotFound();
    }

    /**
     * Render a simple 404 page.
     */
    private function sendNotFound(): void
    {
        http_response_code(404);
        
        // Try to load a custom 404 view if it exists
        $viewPath = dirname(__DIR__, 2) . '/resources/views/public/404.php';
        if (file_exists($viewPath)) {
            require $viewPath;
        } else {
            echo "<h1>404 Not Found</h1>";
            echo "<p>Halaman yang Anda cari tidak ditemukan.</p>";
        }
    }
}
