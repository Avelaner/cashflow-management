<?php

declare(strict_types=1);

namespace App\Models;

use Config\Database;
use PDO;

class User
{
    private static function db(): PDO
    {
        return Database::connect();
    }

    /**
     * Safely check if a column exists in the users table
     */
    private static function columnExists(string $column): bool
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
     * Resolve the expression to retrieve user full name/username safely
     */
    private static function getNameColumnSelect(): string
    {
        if (self::columnExists('name')) {
            return 'name';
        }
        if (self::columnExists('username')) {
            return 'username';
        }
        if (self::columnExists('fullname')) {
            return 'fullname';
        }
        if (self::columnExists('first_name') && self::columnExists('last_name')) {
            return "CONCAT(first_name, ' ', last_name) AS name";
        }
        return "email AS name";
    }

    /**
     * Find a user record by email address (Used by Auth service)
     */
    public static function findByEmail(string $email): ?array
    {
        $db = self::db();
        $nameCol = self::getNameColumnSelect();

        // Check optional columns dynamically so SQL doesn't crash if they don't exist in DB
        $phoneCol = self::columnExists('phone') ? 'phone' : 'NULL AS phone';
        $pictureCol = self::columnExists('picture') ? 'picture' : (self::columnExists('avatar') ? 'avatar AS picture' : 'NULL AS picture');
        $lastLoginCol = self::columnExists('last_login') ? 'last_login' : 'NULL AS last_login';

        $stmt = $db->prepare("
            SELECT id, {$nameCol}, email, password, role, status, 
                   {$phoneCol}, {$pictureCol}, {$lastLoginCol}, created_at 
            FROM users 
            WHERE email = ? 
            LIMIT 1
        ");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    /**
     * Update user's last login timestamp
     */
    public static function updateLastLogin(int $id): bool
    {
        // Only attempt DB update if the last_login column actually exists
        if (!self::columnExists('last_login')) {
            return true; // Gracefully bypass if column hasn't been created yet
        }

        $db = self::db();
        $stmt = $db->prepare("UPDATE users SET last_login = NOW() WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Get all users with search filtering
     */
    public static function getAll(?string $search = null): array
    {
        $db = self::db();
        $nameCol = self::getNameColumnSelect();
        
        if (!empty($search)) {
            $stmt = $db->prepare("
                SELECT id, {$nameCol}, email, role, status, created_at 
                FROM users 
                WHERE email LIKE ? OR role LIKE ? 
                ORDER BY id DESC
            ");
            $searchTerm = "%{$search}%";
            $stmt->execute([$searchTerm, $searchTerm]);
        } else {
            $stmt = $db->query("SELECT id, {$nameCol}, email, role, status, created_at FROM users ORDER BY id DESC");
        }

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Find user by ID
     */
    public static function find(int $id): ?array
    {
        $db = self::db();
        $nameCol = self::getNameColumnSelect();

        $stmt = $db->prepare("SELECT id, {$nameCol}, email, role, status, created_at FROM users WHERE id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        return $user ?: null;
    }

    /**
     * Create a new user
     */
    public static function create(array $data): bool
    {
        $db = self::db();

        $nameField = self::columnExists('name') ? 'name' : (self::columnExists('username') ? 'username' : 'fullname');

        $stmt = $db->prepare("
            INSERT INTO users ({$nameField}, email, password, role, status, created_at) 
            VALUES (?, ?, ?, ?, ?, NOW())
        ");

        return $stmt->execute([
            $data['name'],
            $data['email'],
            password_hash($data['password'], PASSWORD_DEFAULT),
            $data['role'] ?? 'staff',
            $data['status'] ?? 'active'
        ]);
    }

    /**
     * Update user credentials/info
     */
    public static function update(int $id, array $data): bool
    {
        $db = self::db();
        $nameField = self::columnExists('name') ? 'name' : (self::columnExists('username') ? 'username' : 'fullname');

        if (!empty($data['password'])) {
            $stmt = $db->prepare("
                UPDATE users 
                SET {$nameField} = ?, email = ?, role = ?, password = ? 
                WHERE id = ?
            ");
            return $stmt->execute([
                $data['name'],
                $data['email'],
                $data['role'],
                password_hash($data['password'], PASSWORD_DEFAULT),
                $id
            ]);
        }

        $stmt = $db->prepare("UPDATE users SET {$nameField} = ?, email = ?, role = ? WHERE id = ?");
        return $stmt->execute([$data['name'], $data['email'], $data['role'], $id]);
    }

    /**
     * Toggle active/blocked status
     */
    public static function updateStatus(int $id, string $status): bool
    {
        $db = self::db();
        $stmt = $db->prepare("UPDATE users SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    /**
     * Delete user
     */
    public static function delete(int $id): bool
    {
        $db = self::db();
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Check if email exists
     */
    public static function emailExists(string $email, ?int $ignoreId = null): bool
    {
        $db = self::db();
        if ($ignoreId) {
            $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ? AND id != ?");
            $stmt->execute([$email, $ignoreId]);
        } else {
            $stmt = $db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->execute([$email]);
        }

        return (bool) $stmt->fetchColumn();
    }
}