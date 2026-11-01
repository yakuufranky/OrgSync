<?php

declare(strict_types=1);

namespace App\Core;

use PDO;
use PDOException;

/**
 * Singleton Database Connection Manager
 */
class Database
{
    private static ?PDO $instance = null;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * Get active PDO connection instance
     *
     * @return PDO
     * @throws PDOException
     */
    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            $dsn = sprintf(
                'mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                DB_HOST,
                DB_PORT,
                DB_NAME
            );

            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];

            self::$instance = new PDO($dsn, DB_USER, DB_PASS, $options);
        }

        return self::$instance;
    }
}
