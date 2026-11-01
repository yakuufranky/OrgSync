<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

/**
 * Abstract Base Data Model
 */
abstract class Model
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::getConnection();
    }
}
