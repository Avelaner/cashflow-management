<?php

declare(strict_types=1);

namespace App\Models;

// Update this line to point to your Config directory
use App\Config\Database; 
use PDO;
use Exception;

class ItemModel {
    private $db;

    public function __construct($pdo) {
        $this->db = $pdo;
    }

    public function getAllItems() {
        $stmt = $this->db->prepare("SELECT * FROM items ORDER BY id DESC");
        $stmt->execute();
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($items as &$item) {
            $item['status'] = $this->getStockStatus($item['quantity'], $item['min_stock_alert']);
        }

        return $items;
    }

    public function getItemById($id) {
        $stmt = $this->db->prepare("SELECT * FROM items WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createItem($data) {
        $stmt = $this->db->prepare("INSERT INTO items (name, brand, buying_price, selling_price, quantity, min_stock_alert, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
        return $stmt->execute([
            $data['name'],
            $data['brand'] ?? null,
            $data['buying_price'],
            $data['selling_price'],
            $data['quantity'],
            $data['min_stock_alert'] ?? 5,
            $data['description'] ?? null
        ]);
    }

    public function updateItem($id, $data) {
        $stmt = $this->db->prepare("UPDATE items SET name = ?, brand = ?, buying_price = ?, selling_price = ?, quantity = ?, min_stock_alert = ?, description = ? WHERE id = ?");
        return $stmt->execute([
            $data['name'],
            $data['brand'] ?? null,
            $data['buying_price'],
            $data['selling_price'],
            $data['quantity'],
            $data['min_stock_alert'] ?? 5,
            $data['description'] ?? null,
            $id
        ]);
    }

    public function deleteItem($id) {
        $stmt = $this->db->prepare("DELETE FROM items WHERE id = ?");
        return $stmt->execute([$id]);
    }

    public function recordSale($itemId, $quantityToSell) {
        $item = $this->getItemById($itemId);
        if (!$item || $item['quantity'] < $quantityToSell) {
            return false;
        }

        $this->db->beginTransaction();

        try {
            // Update item stock & quantity sold
            $stmt = $this->db->prepare("UPDATE items SET quantity = quantity - ?, quantity_sold = quantity_sold + ? WHERE id = ?");
            $stmt->execute([$quantityToSell, $quantityToSell, $itemId]);

            // Record sale log
            $totalAmount = $quantityToSell * $item['selling_price'];
            $stmtSale = $this->db->prepare("INSERT INTO item_sales (item_id, quantity, unit_price, total_amount) VALUES (?, ?, ?, ?)");
            $stmtSale->execute([$itemId, $quantityToSell, $item['selling_price'], $totalAmount]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    private function getStockStatus($quantity, $minAlert) {
        if ($quantity <= 0) {
            return ['label' => 'Out of Stock', 'badge' => 'bg-danger'];
        } elseif ($quantity <= $minAlert) {
            return ['label' => 'Low Stock', 'badge' => 'bg-warning text-dark'];
        }
        return ['label' => 'In Stock', 'badge' => 'bg-success'];
    }
}