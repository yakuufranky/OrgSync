<?php

declare(strict_types=1);

namespace App\Core;

/**
 * Session State and Flash Message Manager
 */
class Session
{
    /**
     * Initialize session if not active
     */
    public static function start(): void
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Store value in session
     *
     * @param string $key
     * @param mixed $value
     */
    public static function set(string $key, mixed $value): void
    {
        self::start();
        $_SESSION[$key] = $value;
    }

    /**
     * Retrieve value from session
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get(string $key, mixed $default = null): mixed
    {
        self::start();
        return $_SESSION[$key] ?? $default;
    }

    /**
     * Check if key exists in session
     *
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool
    {
        self::start();
        return isset($_SESSION[$key]);
    }

    /**
     * Remove key from session
     *
     * @param string $key
     */
    public static function remove(string $key): void
    {
        self::start();
        unset($_SESSION[$key]);
    }

    /**
     * Set a one-time flash notification
     *
     * @param string $type
     * @param string $message
     */
    public static function setFlash(string $type, string $message): void
    {
        self::start();
        $_SESSION['_flash'][$type] = $message;
    }

    /**
     * Retrieve and clear a flash notification
     *
     * @param string $type
     * @return string|null
     */
    public static function getFlash(string $type): ?string
    {
        self::start();
        if (isset($_SESSION['_flash'][$type])) {
            $msg = $_SESSION['_flash'][$type];
            unset($_SESSION['_flash'][$type]);
            return $msg;
        }
        return null;
    }

    /**
     * Determine if flash message exists
     *
     * @param string $type
     * @return bool
     */
    public static function hasFlash(string $type): bool
    {
        self::start();
        return !empty($_SESSION['_flash'][$type]);
    }

    /**
     * Generate or return existing CSRF token
     *
     * @return string
     */
    public static function csrfToken(): string
    {
        self::start();
        if (empty($_SESSION['_csrf_token'])) {
            $_SESSION['_csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['_csrf_token'];
    }

    /**
     * Validate submitted CSRF token
     *
     * @param string|null $token
     * @return bool
     */
    public static function validateCsrf(?string $token): bool
    {
        self::start();
        if (empty($token) || empty($_SESSION['_csrf_token'])) {
            return false;
        }
        return hash_equals($_SESSION['_csrf_token'], $token);
    }

    /**
     * Destroy current session
     */
    public static function destroy(): void
    {
        self::start();
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params['path'],
                $params['domain'],
                $params['secure'],
                $params['httponly']
            );
        }
        session_destroy();
    }
}
