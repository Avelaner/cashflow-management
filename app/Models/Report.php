<?php

declare(strict_types=1);

namespace App\Models;

use Config\Database;
use PDO;

class Report
{
    private static function db(): PDO
    {
        return Database::connect();
    }

    /**
     * Helper to safely check if a column exists in a given table
     */
    private static function columnExists(string $table, string $column): bool
    {
        $db = self::db();
        $stmt = $db->prepare("
            SELECT COUNT(*) 
            FROM information_schema.COLUMNS 
            WHERE TABLE_SCHEMA = DATABASE() 
              AND TABLE_NAME = ? 
              AND COLUMN_NAME = ?
        ");
        $stmt->execute([$table, $column]);
        return (bool) $stmt->fetchColumn();
    }

    /**
     * Aggregated financial totals (Deposits, Withdrawals, Expenses, Net Cashflow)
     */
    public static function getFinancialOverview(?string $startDate = null, ?string $endDate = null): array
    {
        $db = self::db();
        
        $params = [];
        $dateFilter = "";

        if ($startDate && $endDate) {
            $dateFilter = " WHERE DATE(created_at) BETWEEN ? AND ?";
            $params = [$startDate, $endDate];
        }

        // Total Deposits
        $stmtDep = $db->prepare("SELECT COALESCE(SUM(amount), 0) FROM deposits {$dateFilter}");
        $stmtDep->execute($params);
        $totalDeposits = (float)$stmtDep->fetchColumn();

        // Total Withdrawals
        $stmtWith = $db->prepare("SELECT COALESCE(SUM(amount), 0) FROM withdrawals {$dateFilter}");
        $stmtWith->execute($params);
        $totalWithdrawals = (float)$stmtWith->fetchColumn();

        // Total Expenses
        $stmtExp = $db->prepare("SELECT COALESCE(SUM(amount), 0) FROM expenses {$dateFilter}");
        $stmtExp->execute($params);
        $totalExpenses = (float)$stmtExp->fetchColumn();

        // Inventory Stock Value
        $itemCost = 0.0;
        $itemRetail = 0.0;
        
        try {
            $stmtItems = $db->query("SELECT COALESCE(SUM(buying_price * quantity), 0) AS cost_value, COALESCE(SUM(selling_price * quantity), 0) AS retail_value FROM items");
            $itemStats = $stmtItems->fetch(PDO::FETCH_ASSOC);
            $itemCost = (float)($itemStats['cost_value'] ?? 0);
            $itemRetail = (float)($itemStats['retail_value'] ?? 0);
        } catch (\PDOException $e) {
            // Skips gracefully if items table is not used
        }

        $netCashflow = $totalDeposits - ($totalWithdrawals + $totalExpenses);

        return [
            'total_deposits'    => $totalDeposits,
            'total_withdrawals' => $totalWithdrawals,
            'total_expenses'    => $totalExpenses,
            'net_cashflow'      => $netCashflow,
            'inventory_cost'    => $itemCost,
            'inventory_retail'  => $itemRetail,
        ];
    }

    /**
     * Combined ledger entries for deposits, withdrawals, and expenses
     */
    public static function getCombinedLedger(?string $startDate = null, ?string $endDate = null): array
    {
        $db = self::db();

        // Detect column names dynamically via information_schema
        $depRef   = self::columnExists('deposits', 'reference_no') ? 'reference_no' : (self::columnExists('deposits', 'reference') ? 'reference' : "''");
        $withRef  = self::columnExists('withdrawals', 'reference_no') ? 'reference_no' : (self::columnExists('withdrawals', 'reference') ? 'reference' : "''");
        $expRef   = self::columnExists('expenses', 'category') ? 'category' : (self::columnExists('expenses', 'reference') ? 'reference' : "''");

        $depDesc  = self::columnExists('deposits', 'description') ? 'description' : (self::columnExists('deposits', 'notes') ? 'notes' : "''");
        $withDesc = self::columnExists('withdrawals', 'description') ? 'description' : (self::columnExists('withdrawals', 'notes') ? 'notes' : "''");
        $expDesc  = self::columnExists('expenses', 'description') ? 'description' : (self::columnExists('expenses', 'notes') ? 'notes' : "''");

        $dateFilter = "";
        $queryParams = [];

        if ($startDate && $endDate) {
            $dateFilter = " WHERE DATE(created_at) BETWEEN ? AND ?";
            $queryParams = [
                $startDate, $endDate,
                $startDate, $endDate,
                $startDate, $endDate
            ];
        }

        // Use CONVERT(... USING utf8mb4) to guarantee uniform collation across UNION rows
        $sql = "
            SELECT 
                CONVERT('deposit' USING utf8mb4) AS type, 
                id, 
                amount, 
                CONVERT({$depRef} USING utf8mb4) AS reference, 
                CONVERT({$depDesc} USING utf8mb4) AS description, 
                created_at 
            FROM deposits {$dateFilter}
            
            UNION ALL
            
            SELECT 
                CONVERT('withdrawal' USING utf8mb4) AS type, 
                id, 
                amount, 
                CONVERT({$withRef} USING utf8mb4) AS reference, 
                CONVERT({$withDesc} USING utf8mb4) AS description, 
                created_at 
            FROM withdrawals {$dateFilter}
            
            UNION ALL
            
            SELECT 
                CONVERT('expense' USING utf8mb4) AS type, 
                id, 
                amount, 
                CONVERT({$expRef} USING utf8mb4) AS reference, 
                CONVERT({$expDesc} USING utf8mb4) AS description, 
                created_at 
            FROM expenses {$dateFilter}
            
            ORDER BY created_at DESC
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute($queryParams);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}