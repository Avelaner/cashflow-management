<?php

declare(strict_types=1);

namespace App\Models;

use Config\Database;
use PDO;

class Activity
{
    private static function db(): PDO
    {
        return Database::connect();
    }

    /**
     * Check if a column exists in the users table
     */
    private static function userColumnExists(string $column): bool
    {
        $db = self::db();
        $stmt = $db->prepare("
            SELECT COUNT(*) 
            FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = DATABASE() 
              AND TABLE_NAME = 'users' 
              AND COLUMN_NAME = ?
        ");
        $stmt->execute([$column]);
        return (bool) $stmt->fetchColumn();
    }

    /**
     * Resolve the exact user expression for SELECT queries
     */
    private static function getUserSelectExpression(): string
    {
        if (self::userColumnExists('name')) {
            return 'u.name';
        }
        if (self::userColumnExists('full_name')) {
            return 'u.full_name';
        }
        if (self::userColumnExists('fullname')) {
            return 'u.fullname';
        }
        if (self::userColumnExists('username')) {
            return 'u.username';
        }
        if (self::userColumnExists('first_name') && self::userColumnExists('last_name')) {
            return "CONCAT(u.first_name, ' ', u.last_name)";
        }
        return 'u.email';
    }

    /**
     * Log a new system activity
     */
    public static function log(string $action, string $description, ?int $userId = null): bool
    {
        $db = self::db();
        $ip = $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1';

        $stmt = $db->prepare("
            INSERT INTO activities (user_id, action, description, ip_address, created_at)
            VALUES (?, ?, ?, ?, NOW())
        ");

        return $stmt->execute([$userId, $action, $description, $ip]);
    }

    /**
     * Get all activities with optional search filtering
     */
    public static function getAll(?string $search = null): array
    {
        $db = self::db();
        $userSelect = self::getUserSelectExpression();

        $sql = "
            SELECT a.*, COALESCE({$userSelect}, 'System') AS user_name
            FROM activities a
            LEFT JOIN users u ON a.user_id = u.id
        ";

        if (!empty($search)) {
            $sql .= " WHERE a.action LIKE ? OR a.description LIKE ? OR {$userSelect} LIKE ? ORDER BY a.id DESC";
            $stmt = $db->prepare($sql);
            $term = "%{$search}%";
            $stmt->execute([$term, $term, $term]);
        } else {
            $sql .= " ORDER BY a.id DESC LIMIT 100";
            $stmt = $db->query($sql);
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Clear older activity logs
     */
    public static function clearAll(): bool
    {
        $db = self::db();
        return (bool) $db->exec("TRUNCATE TABLE activities");
    }
}