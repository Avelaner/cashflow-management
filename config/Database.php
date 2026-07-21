<?php

declare(strict_types=1);

namespace Config;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $connection = null;

    /**
     * Get Singleton Database Connection instance.
     */
    public static function connect(): PDO
    {
        if (self::$connection !== null) {
            return self::$connection;
        }

        $host     = $_ENV['DB_HOST'] ?? '127.0.0.1';
        $port     = $_ENV['DB_PORT'] ?? '3306';
        $dbname   = $_ENV['DB_DATABASE'] ?? '';
        $username = $_ENV['DB_USERNAME'] ?? 'root';
        $password = $_ENV['DB_PASSWORD'] ?? '';

        $dsn = sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4', $host, $port, $dbname);

        try {
            self::$connection = new PDO($dsn, $username, $password, [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
            ]);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }

        return self::$connection;
    }
}