<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

/**
 * Lightweight HTTP Request Router
 */
class Router
{
    /** @var array<string, array<string, callable|string|array>> */
    private static array $routes = [];

    /**
     * Register GET route
     *
     * @param string $path
     * @param callable|string|array $handler
     */
    public static function get(string $path, callable|string|array $handler): void
    {
        self::$routes['GET'][self::normalizePath($path)] = $handler;
    }

    /**
     * Register POST route
     *
     * @param string $path
     * @param callable|string|array $handler
     */
    public static function post(string $path, callable|string|array $handler): void
    {
        self::$routes['POST'][self::normalizePath($path)] = $handler;
    }

    /**
     * Dispatch incoming request to matching handler
     */
    public static function dispatch(): void
    {
        $method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
        $uri = self::resolveUri();

        $handler = self::$routes[$method][$uri] ?? null;

        if ($handler === null) {
            http_response_code(404);
            $notFoundView = APP_PATH . '/Views/errors/404.php';
            if (file_exists($notFoundView)) {
                require $notFoundView;
            } else {
                echo '<div style="font-family: sans-serif; text-align: center; padding: 50px;">'
                   . '<h1>404 Not Found</h1>'
                   . '<p>The requested page <code>' . htmlspecialchars($uri) . '</code> was not found.</p>'
                   . '<p><a href="' . BASE_URL . '/">Return to Home</a></p>'
                   . '</div>';
            }
            return;
        }

        self::executeHandler($handler);
    }

    /**
     * Resolve cleaned request URI relative to application root
     *
     * @return string
     */
    private static function resolveUri(): string
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'] ?? '/', PHP_URL_PATH) ?: '/';
        $scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
        $parentDir = str_ends_with($scriptDir, '/public') ? rtrim(str_replace('\\', '/', dirname($scriptDir)), '/') : '';

        if ($scriptDir !== '/' && str_starts_with($requestUri, $scriptDir)) {
            $requestUri = substr($requestUri, strlen($scriptDir));
        } elseif ($parentDir !== '' && $parentDir !== '/' && str_starts_with($requestUri, $parentDir)) {
            $requestUri = substr($requestUri, strlen($parentDir));
        }

        return self::normalizePath($requestUri ?: '/');
    }

    /**
     * Normalize URL path
     *
     * @param string $path
     * @return string
     */
    private static function normalizePath(string $path): string
    {
        $trimmed = '/' . trim($path, '/');
        return $trimmed === '//' ? '/' : $trimmed;
    }

    /**
     * Execute callable or controller action
     *
     * @param callable|string|array $handler
     */
    private static function executeHandler(callable|string|array $handler): void
    {
        if (is_callable($handler)) {
            $handler();
            return;
        }

        if (is_string($handler) && str_contains($handler, '@')) {
            [$controllerName, $action] = explode('@', $handler, 2);
            $fullClass = 'App\\Controllers\\' . $controllerName;

            if (!class_exists($fullClass)) {
                throw new RuntimeException("Controller class not found: {$fullClass}");
            }

            $controller = new $fullClass();
            if (!method_exists($controller, $action)) {
                throw new RuntimeException("Action method '{$action}' not found in {$fullClass}");
            }

            $controller->$action();
            return;
        }

        if (is_array($handler) && count($handler) === 2) {
            [$class, $action] = $handler;
            $controller = is_object($class) ? $class : new $class();
            $controller->$action();
            return;
        }

        throw new RuntimeException("Invalid route handler format");
    }
}
