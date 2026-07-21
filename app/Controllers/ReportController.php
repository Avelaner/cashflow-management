<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Report;
use App\Services\PermissionService;

class ReportController
{
    public function index(): void
    {
        // 1. Permission Guard
        if (!PermissionService::can('reports.view')) {
            http_response_code(403);
            require_once __DIR__ . '/../Views/errors/403.php';
            return;
        }

        // 2. Read Date Range Filters
        $startDate = $_GET['start_date'] ?? date('Y-m-01');
        $endDate   = $_GET['end_date']   ?? date('Y-m-d');

        // 3. Fetch Data
        $summary = Report::getFinancialOverview($startDate, $endDate);
        $ledger  = Report::getCombinedLedger($startDate, $endDate);

        $pageTitle = 'Financial Reports & Analytics';

        // 4. Render View
        require_once __DIR__ . '/../Views/reports/index.php';
    }
}