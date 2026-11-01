<?php

declare(strict_types=1);

namespace App\Core;

use RuntimeException;

/**
 * Abstract Base Controller
 */
abstract class Controller
{
    /**
     * Render view template inside chosen layout
     *
     * @param string $view Relative view path inside app/Views (e.g. 'auth/login')
     * @param array<string, mixed> $data Variables passed to the view
     * @param string $layout Layout template filename without extension
     */
    protected function view(string $view, array $data = [], string $layout = 'auth'): void
    {
        extract($data, EXTR_SKIP);

        $viewFile = APP_PATH . '/Views/' . ltrim($view, '/') . '.php';
        if (!file_exists($viewFile)) {
            throw new RuntimeException("View file not found: {$viewFile}");
        }

        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        if ($layout === '') {
            echo $content;
            return;
        }

        $layoutFile = APP_PATH . '/Views/layouts/' . $layout . '.php';
        if (!file_exists($layoutFile)) {
            throw new RuntimeException("Layout file not found: {$layoutFile}");
        }

        require $layoutFile;
    }

    /**
     * Send JSON response and terminate execution
     *
     * @param array<string, mixed> $data
     * @param int $statusCode
     */
    protected function json(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        exit;
    }

    /**
     * Redirect to relative route or external URI
     *
     * @param string $path
     */
    protected function redirect(string $path): void
    {
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            header('Location: ' . $path);
        } else {
            $target = rtrim(BASE_URL, '/') . '/' . ltrim($path, '/');
            header('Location: ' . $target);
        }
        exit;
    }
}
