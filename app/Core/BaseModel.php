<?php

declare(strict_types=1);

namespace App\Core;

use Config\Database;
use PDO;

abstract class BaseModel
{
    protected PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }
}