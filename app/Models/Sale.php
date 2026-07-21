<?php

declare(strict_types=1);

namespace App\Models;

use Config\Database;
use PDO;
use Exception;

class Sale
{
    public static function create(array $data): bool
    {
        try {
            $db = Database::connect();
            $stmt = $db->prepare("
                INSERT INTO sales (item_id, customer_id, sold_by, quantity, unit_price, total_amount)
                VALUES (:item_id, :customer_id, :sold_by, :quantity, :unit_price, :total_amount)
            ");

            // Explicitly bind customer_id as NULL if not provided
            $stmt->bindValue(':item_id', $data['item_id'], PDO::PARAM_INT);
            if (!empty($data['customer_id'])) {
                $stmt->bindValue(':customer_id', $data['customer_id'], PDO::PARAM_INT);
            } else {
                $stmt->bindValue(':customer_id', null, PDO::PARAM_NULL);
            }
            $stmt->bindValue(':sold_by', $data['sold_by'], PDO::PARAM_INT);
            $stmt->bindValue(':quantity', $data['quantity'], PDO::PARAM_INT);
            $stmt->bindValue(':unit_price', $data['unit_price']);
            $stmt->bindValue(':total_amount', $data['total_amount']);

            return $stmt->execute();
        } catch (Exception $e) {
            error_log("Sale creation failed: " . $e->getMessage());
            return false;
        }
    }

    public static function getAllWithDetails(): array
{
    try {
        $db = Database::connect();

        $sql = "SELECT 
                    s.id AS id,
                    s.item_id,
                    s.customer_id,
                    s.sold_by,
                    s.quantity,
                    s.unit_price,
                    s.total_amount,
                    s.created_at AS sold_at,
                    i.name AS item_name,
                    c.fullname,
                    c.phone,
                    c.email,
                    c.gender,
                    c.occupation,
                    c.address,
                    COALESCE(u.fullname, 'System Administrator') AS sold_by_user
                FROM sales s
                LEFT JOIN items i ON s.item_id = i.id
                LEFT JOIN customers c ON s.customer_id = c.id
                LEFT JOIN users u ON s.sold_by = u.id
                ORDER BY s.id DESC";

        $stmt = $db->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: [];
    } catch (\Throwable $e) {
        // Intercept silent error and show exact issue
        die('<h3>Sales Query Debug Error:</h3>' . $e->getMessage());
    }
}
}