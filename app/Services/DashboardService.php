<?php

declare(strict_types=1);

namespace App\Services;

use Config\Database;
use PDO;

class DashboardService
{
    /**
     * Helper to safely calculate percentage growth.
     */
    private static function calculateGrowth(float $current, float $previous): array
    {
        if ($previous > 0) {
            $percent = (($current - $previous) / $previous) * 100;
        } else {
            $percent = $current > 0 ? 100 : 0;
        }

        $rounded = round($percent, 1);

        return [
            'value'     => abs($rounded),
            'is_up'     => $rounded >= 0,
            'formatted' => ($rounded >= 0 ? '+' : '-') . abs($rounded) . '%',
        ];
    }

    /**
     * Dashboard statistics with real data & growth calculations.
     */
    public static function getStats(): array
    {
        $db = Database::connect();

        // 1. Customers & Growth
        $custStats = $db->query("
            SELECT 
                COUNT(*) AS total,
                COUNT(CASE WHEN MONTH(created_at) = MONTH(CURRENT_DATE()) AND YEAR(created_at) = YEAR(CURRENT_DATE()) THEN 1 END) AS current_month,
                COUNT(CASE WHEN MONTH(created_at) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) AND YEAR(created_at) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH) THEN 1 END) AS prev_month
            FROM customers
        ")->fetch(PDO::FETCH_ASSOC);

        // 2. Deposits & Growth
        $depStats = $db->query("
            SELECT 
                COALESCE(SUM(amount), 0) AS total,
                COALESCE(SUM(CASE WHEN DATE(transaction_date) = CURRENT_DATE() THEN amount END), 0) AS today,
                COALESCE(SUM(CASE WHEN DATE(transaction_date) = CURRENT_DATE() - INTERVAL 1 DAY THEN amount END), 0) AS yesterday
            FROM deposits
        ")->fetch(PDO::FETCH_ASSOC);

        // 3. Withdrawals & Growth
        $withStats = $db->query("
            SELECT 
                COALESCE(SUM(amount), 0) AS total,
                COALESCE(SUM(CASE WHEN MONTH(transaction_date) = MONTH(CURRENT_DATE()) AND YEAR(transaction_date) = YEAR(CURRENT_DATE()) THEN amount END), 0) AS current_month,
                COALESCE(SUM(CASE WHEN MONTH(transaction_date) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) AND YEAR(transaction_date) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH) THEN amount END), 0) AS prev_month
            FROM withdrawals
        ")->fetch(PDO::FETCH_ASSOC);

        // 4. Expenses & Growth
        $expStats = $db->query("
            SELECT 
                COALESCE(SUM(amount), 0) AS total,
                COALESCE(SUM(CASE WHEN MONTH(transaction_date) = MONTH(CURRENT_DATE()) AND YEAR(transaction_date) = YEAR(CURRENT_DATE()) THEN amount END), 0) AS current_month,
                COALESCE(SUM(CASE WHEN MONTH(transaction_date) = MONTH(CURRENT_DATE() - INTERVAL 1 MONTH) AND YEAR(transaction_date) = YEAR(CURRENT_DATE() - INTERVAL 1 MONTH) THEN amount END), 0) AS prev_month
            FROM expenses
        ")->fetch(PDO::FETCH_ASSOC);

        return [
            'customers'          => (int) $custStats['total'],
            'customers_growth'   => self::calculateGrowth((float) $custStats['current_month'], (float) $custStats['prev_month']),

            'deposits'           => (float) $depStats['total'],
            'deposits_growth'    => self::calculateGrowth((float) $depStats['today'], (float) $depStats['yesterday']),

            'withdrawals'        => (float) $withStats['total'],
            'withdrawals_growth' => self::calculateGrowth((float) $withStats['current_month'], (float) $withStats['prev_month']),

            'expenses'           => (float) $expStats['total'],
            'expenses_growth'    => self::calculateGrowth((float) $expStats['current_month'], (float) $expStats['prev_month']),
        ];
    }

    /**
     * Counts for today's summary.
     */
    public static function getTodaySummary(): array
    {
        $db = Database::connect();

        $custToday = $db->query("SELECT COUNT(*) FROM customers WHERE DATE(created_at) = CURRENT_DATE()")->fetchColumn();
        $depToday  = $db->query("SELECT COUNT(*) FROM deposits WHERE DATE(transaction_date) = CURRENT_DATE()")->fetchColumn();
        $withToday = $db->query("SELECT COUNT(*) FROM withdrawals WHERE DATE(transaction_date) = CURRENT_DATE()")->fetchColumn();
        $expToday  = $db->query("SELECT COUNT(*) FROM expenses WHERE DATE(created_at) = CURRENT_DATE()")->fetchColumn();

        return [
            'customers'   => (int) $custToday,
            'deposits'    => (int) $depToday,
            'withdrawals' => (int) $withToday,
            'expenses'    => (int) $expToday,
        ];
    }

    /**
     * Fetch monthly cashflow in/out arrays for current year.
     */
    public static function getMonthlyCashflow(): array
    {
        $db = Database::connect();
        $year = (int) date('Y');

        // Inflows (Deposits)
        $stmtIn = $db->prepare("
            SELECT MONTH(transaction_date) AS month_num, COALESCE(SUM(amount), 0) AS total
            FROM deposits 
            WHERE YEAR(transaction_date) = :year
            GROUP BY MONTH(transaction_date)
        ");
        $stmtIn->execute([':year' => $year]);
        $inflowData = $stmtIn->fetchAll(PDO::FETCH_KEY_PAIR);

        // Outflows (Withdrawals)
        $stmtOut = $db->prepare("
            SELECT MONTH(transaction_date) AS month_num, COALESCE(SUM(amount), 0) AS total
            FROM withdrawals 
            WHERE YEAR(transaction_date) = :year
            GROUP BY MONTH(transaction_date)
        ");
        $stmtOut->execute([':year' => $year]);
        $outflowData = $stmtOut->fetchAll(PDO::FETCH_KEY_PAIR);

        $inflows  = [];
        $outflows = [];
        for ($month = 1; $month <= 12; $month++) {
            $inflows[]  = (float) ($inflowData[$month] ?? 0);
            $outflows[] = (float) ($outflowData[$month] ?? 0);
        }

        return [
            'inflows'  => $inflows,
            'outflows' => $outflows,
        ];
    }

    /**
     * Fetch cashflow chart dataset based on period filter (daily, weekly, monthly).
     */
    public static function getCashflowData(string $period = 'monthly'): array
    {
        $db = Database::connect();

        switch ($period) {
            case 'daily':
                // Last 7 days
                $stmt = $db->query("
                    SELECT DATE_FORMAT(transaction_date, '%d %b') AS label, COALESCE(SUM(amount), 0) AS total
                    FROM deposits
                    WHERE transaction_date >= CURRENT_DATE() - INTERVAL 6 DAY
                    GROUP BY DATE(transaction_date)
                    ORDER BY DATE(transaction_date) ASC
                ");
                $data = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

                $labels = [];
                $totals = [];
                for ($i = 6; $i >= 0; $i--) {
                    $dateKey  = date('d M', strtotime("-{$i} days"));
                    $labels[] = $dateKey;
                    $totals[] = (float) ($data[$dateKey] ?? 0);
                }
                return ['labels' => $labels, 'data' => $totals];

            case 'weekly':
                // Last 4 weeks
                $labels = [];
                $totals = [];
                for ($i = 3; $i >= 0; $i--) {
                    $weekLabel = $i === 0 ? 'This Week' : "{$i} Wks Ago";
                    $stmt = $db->prepare("
                        SELECT COALESCE(SUM(amount), 0)
                        FROM deposits
                        WHERE transaction_date >= CURRENT_DATE() - INTERVAL :start DAY
                          AND transaction_date < CURRENT_DATE() - INTERVAL :end DAY
                    ");
                    $stmt->execute([
                        ':start' => ($i + 1) * 7,
                        ':end'   => $i * 7,
                    ]);

                    $labels[] = $weekLabel;
                    $totals[] = (float) $stmt->fetchColumn();
                }
                return ['labels' => $labels, 'data' => $totals];

            case 'monthly':
            default:
                // All 12 months of the current year
                $stmt = $db->query("
                    SELECT MONTH(transaction_date) AS month_num, COALESCE(SUM(amount), 0) AS total
                    FROM deposits
                    WHERE YEAR(transaction_date) = YEAR(CURRENT_DATE())
                    GROUP BY MONTH(transaction_date)
                ");
                $monthlyData = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

                $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
                $totals = [];
                for ($m = 1; $m <= 12; $m++) {
                    $totals[] = (float) ($monthlyData[$m] ?? 0);
                }
                return ['labels' => $labels, 'data' => $totals];
        }
    }

    /**
     * Recent transactions (union of deposits & withdrawals).
     */
    public static function getRecentTransactions(int $limit = 5): array
    {
        $db = Database::connect();

        $sql = "
            (SELECT c.fullname AS customer, 'Deposit' AS type, d.amount, d.transaction_date AS created_at
             FROM deposits d
             JOIN customers c ON d.customer_id = c.id)
            UNION ALL
            (SELECT c.fullname AS customer, 'Withdrawal' AS type, w.amount, w.transaction_date AS created_at
             FROM withdrawals w
             JOIN customers c ON w.customer_id = c.id)
            ORDER BY created_at DESC
            LIMIT :limit
        ";

        $stmt = $db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Recent customers registered.
     */
    public static function getRecentCustomers(int $limit = 5): array
    {
        $db = Database::connect();

        $stmt = $db->prepare("
            SELECT fullname 
            FROM customers 
            ORDER BY created_at DESC 
            LIMIT :limit
        ");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}