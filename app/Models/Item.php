<?php

declare(strict_types=1);

namespace App\Models;

use Config\Database;
use PDO;
use Exception;

class Item
{
    private static function db(): PDO
    {
        return Database::connect();
    }

    public static function getAll(): array
{
    $stmt = self::db()->query("
        SELECT 
            i.*, 
            COALESCE(SUM(s.quantity), 0) AS quantity_sold
        FROM items i
        LEFT JOIN sales s ON i.id = s.item_id
        GROUP BY i.id
        ORDER BY i.id DESC
    ");
    $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($items as &$item) {
        $item['status'] = self::calculateStatus((int) $item['quantity'], (int) ($item['min_stock_alert'] ?? 5));
    }

    return $items;
}

    public static function getSummaryStats(): array
    {
        $stmt = self::db()->query("
            SELECT 
                COUNT(*) AS total_items,
                COALESCE(SUM(buying_price * quantity), 0) AS total_buying_price,
                COALESCE(SUM(selling_price * quantity), 0) AS total_selling_price,
                COALESCE(SUM(quantity), 0) AS total_items_instock
            FROM items
        ");
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [
            'total_items' => 0,
            'total_buying_price' => 0.00,
            'total_selling_price' => 0.00,
            'total_items_instock' => 0
        ];
    }

    public static function find(int $id): ?array
    {
        $stmt = self::db()->prepare("SELECT * FROM items WHERE id = ?");
        $stmt->execute([$id]);
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        return $item ?: null;
    }

    public static function create(array $data): bool
    {
        $stmt = self::db()->prepare("
            INSERT INTO items (name, brand, description, buying_price, selling_price, quantity, min_stock_alert)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $data['name'],
            $data['brand'] ?: null,
            $data['description'] ?: null,
            $data['buying_price'],
            $data['selling_price'],
            $data['quantity'],
            $data['min_stock_alert']
        ]);
    }

    public static function update(int $id, array $data): bool
    {
        $stmt = self::db()->prepare("
            UPDATE items 
            SET name = ?, brand = ?, description = ?, buying_price = ?, selling_price = ?, quantity = ?, min_stock_alert = ?
            WHERE id = ?
        ");

        return $stmt->execute([
            $data['name'],
            $data['brand'] ?: null,
            $data['description'] ?: null,
            $data['buying_price'],
            $data['selling_price'],
            $data['quantity'],
            $data['min_stock_alert'],
            $id
        ]);
    }

    /**
     * Stock reduction helper (called directly by ItemController during transactions)
     */
    public static function sell(int $id, int $quantity): bool
    {
        try {
            $db = self::db();

            $stmtUpdate = $db->prepare("
                UPDATE items 
                SET quantity = quantity - ? 
                WHERE id = ? AND quantity >= ?
            ");
            $stmtUpdate->execute([$quantity, $id, $quantity]);

            return $stmtUpdate->rowCount() > 0;
        } catch (Exception $e) {
            error_log("Item::sell failed: " . $e->getMessage());
            return false;
        }
    }

    public static function delete(int $id): bool
    {
        $stmt = self::db()->prepare("DELETE FROM items WHERE id = ?");
        return $stmt->execute([$id]);
    }

    private static function calculateStatus(int $quantity, int $minAlert): array
    {
        if ($quantity <= 0) {
            return ['label' => 'Out of Stock', 'badge' => 'bg-danger'];
        }
        if ($quantity <= $minAlert) {
            return ['label' => 'Low Stock', 'badge' => 'bg-warning text-dark'];
        }
        return ['label' => 'In Stock', 'badge' => 'bg-success'];
    }
}