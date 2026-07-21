<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Authorization;
use App\Core\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    /**
     * Display the main dashboard page.
     */
    public function index(): void
    {
        // Authentication & Authorization
        Authorization::authorize('dashboard.view');

        // Fetch Dashboard Data
        $stats        = DashboardService::getStats();
        $summary      = DashboardService::getTodaySummary();
        $cashflow     = DashboardService::getMonthlyCashflow();
        $transactions = DashboardService::getRecentTransactions();
        $customers    = DashboardService::getRecentCustomers();

        // Render View
        $this->view('dashboard/index', [
            'title'        => 'Dashboard',
            'stats'        => $stats,
            'summary'      => $summary,
            'cashflow'     => $cashflow,
            'transactions' => $transactions,
            'customers'    => $customers,
        ]);
    }

    public function cashflowData(): void
{
    Authorization::authorize('dashboard.view');

    $period = $_GET['period'] ?? 'monthly';
    $data = DashboardService::getCashflowData($period);

    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}
}