<style>
    :root {
        --primary-color: #2563eb;
        --success-color: #16a34a;
        --warning-color: #d97706;
        --danger-color: #dc2626;
        --purple-color: #9333ea;
        --bg-card: #ffffff;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
    }

    .activity-container {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        color: var(--text-dark);
        padding: 24px;
        max-width: 1200px;
        margin: 0 auto;
    }

    .activity-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 24px;
        gap: 16px;
    }
    .activity-header h2 { margin: 0 0 4px 0; font-size: 1.5rem; font-weight: 700; }
    .activity-header p { margin: 0; color: var(--text-muted); font-size: 0.875rem; }

    .header-actions { display: flex; gap: 8px; flex-wrap: wrap; }
    .btn-action {
        display: inline-flex;
        align-items: center;
        padding: 8px 14px;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: 1px solid transparent;
        transition: background-color 0.2s ease;
    }
    .btn-print { background-color: #0284c7; color: white; border-color: #0284c7; }
    .btn-print:hover { background-color: #0369a1; }
    .btn-dashboard { background-color: #f1f5f9; color: var(--text-dark); border-color: var(--border-color); }
    .btn-dashboard:hover { background-color: #e2e8f0; }
    .btn-danger-outline { background-color: #fff; color: var(--danger-color); border-color: #fecaca; }
    .btn-danger-outline:hover { background-color: #fee2e2; }

    /* KPI Summary Cards */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    .kpi-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-left: 4px solid var(--primary-color);
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .kpi-card.purple { border-left-color: var(--purple-color); }
    .kpi-card.success { border-left-color: var(--success-color); }
    .kpi-card.warning { border-left-color: var(--warning-color); }

    .kpi-title { font-size: 0.75rem; font-weight: 700; text-transform: uppercase; color: var(--text-muted); }
    .kpi-value { font-size: 1.5rem; font-weight: 700; margin: 6px 0; }
    .kpi-subtext { font-size: 0.75rem; color: var(--text-muted); }

    /* Filter Card */
    .filter-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .filter-form { display: flex; gap: 12px; align-items: center; }
    .form-control {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 0.875rem;
        width: 100%;
    }

    /* Table Component */
    .table-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        margin-bottom: 32px;
    }
    .activity-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem; }
    .activity-table th { background-color: #f1f5f9; padding: 12px 16px; font-weight: 600; color: var(--text-muted); border-bottom: 1px solid var(--border-color); }
    .activity-table td { padding: 12px 16px; border-bottom: 1px solid var(--border-color); }
    .activity-table tr:hover { background-color: #f8fafc; }

    .badge-action {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
        background-color: #e2e8f0;
        color: #334155;
    }

    /* Footer Branding */
    .activity-footer {
        margin-top: 40px;
        padding-top: 16px;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        font-size: 0.8125rem;
        color: var(--text-muted);
        gap: 8px;
    }

    /* PRINT STYLES */
    @media print {
        body { background: #fff !important; color: #000 !important; }
        .activity-container { padding: 0 !important; max-width: 100% !important; }
        .header-actions, .filter-card { display: none !important; }
        .table-card, .kpi-card { box-shadow: none !important; border: 1px solid #ccc !important; }
        .activity-table th { background-color: #eee !important; color: #000 !important; }
        .activity-footer { border-top: 1px solid #ccc !important; position: fixed; bottom: 0; width: 100%; }
    }
</style>

<?php

// Defensive initialization to prevent TypeError if $activities is null or undefined
$activitiesList = is_array($activities ?? null) ? $activities : [];

$totalLogs      = count($activitiesList);

$userActions    = count(array_filter($activitiesList, function($a) {
    $action = strtolower($a['action'] ?? '');
    return str_contains($action, 'user');
}));

$salesActions   = count(array_filter($activitiesList, function($a) {
    $action = strtolower($a['action'] ?? '');
    return str_contains($action, 'sale') || str_contains($action, 'item');
}));

$systemActions  = count(array_filter($activitiesList, function($a) {
    $action = strtolower($a['action'] ?? '');
    return str_contains($action, 'login') || str_contains($action, 'auth');
}));
?>

<div class="activity-container">

    <!-- HEADER -->
    <div class="activity-header">
        <div>
            <h2>Activity & Audit Logs</h2>
            <p>Track system events, user actions, login attempts, and database modifications.</p>
        </div>
        <div class="header-actions">
            <!-- PRINT BUTTON -->
            <button onclick="window.print()" class="btn-action btn-print">Print Audit Log</button>
            <a href="<?= base_url('dashboard') ?>" class="btn-action btn-dashboard">Dashboard</a>
            <form method="POST" action="<?= base_url('activities/clear') ?>" style="display:inline;" onsubmit="return confirm('Clear all activity logs?');">
                <button type="submit" class="btn-action btn-danger-outline">Clear Logs</button>
            </form>
        </div>
    </div>

    <!-- KPI SUMMARY CARDS -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-title">Total Logged Events</div>
            <div class="kpi-value" style="color: var(--primary-color);"><?= number_format($totalLogs) ?></div>
            <div class="kpi-subtext">Recorded operations</div>
        </div>

        <div class="kpi-card purple">
            <div class="kpi-title">User Management Events</div>
            <div class="kpi-value" style="color: var(--purple-color);"><?= number_format($userActions) ?></div>
            <div class="kpi-subtext">User updates & creations</div>
        </div>

        <div class="kpi-card success">
            <div class="kpi-title">Sales & Inventory Events</div>
            <div class="kpi-value" style="color: var(--success-color);"><?= number_format($salesActions) ?></div>
            <div class="kpi-subtext">Item & transaction logs</div>
        </div>

        <div class="kpi-card warning">
            <div class="kpi-title">Auth & Access Events</div>
            <div class="kpi-value" style="color: var(--warning-color);"><?= number_format($systemActions) ?></div>
            <div class="kpi-subtext">Logins & authentication</div>
        </div>
    </div>

    <!-- FILTER / SEARCH -->
    <div class="filter-card">
        <form method="GET" action="<?= base_url('activities') ?>" class="filter-form">
            <input type="text" name="search" class="form-control" placeholder="Search by user, action, or description..." value="<?= htmlspecialchars($search ?? '') ?>">
            <button type="submit" class="btn-action btn-dashboard">Search</button>
            <?php if (!empty($search)): ?>
                <a href="<?= base_url('activities') ?>" class="btn-action btn-dashboard">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- ACTIVITY TABLE -->
    <div class="table-card">
        <table class="activity-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>IP Address</th>
                    <th>Date & Time</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($activitiesList)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 24px;">No activity logs found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($activitiesList as $idx => $act): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td><strong><?= htmlspecialchars($act['user_name'] ?? 'System') ?></strong></td>
                            <td><span class="badge-action"><?= strtoupper(htmlspecialchars($act['action'] ?? 'UNKNOWN')) ?></span></td>
                            <td><?= htmlspecialchars($act['description'] ?? '') ?></td>
                            <td><code><?= htmlspecialchars($act['ip_address'] ?? '127.0.0.1') ?></code></td>
                            <td><?= !empty($act['created_at']) ? date('d M, Y h:i A', strtotime($act['created_at'])) : 'N/A' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- SYSTEM FOOTER -->
    <footer class="activity-footer">
        <div>
            &copy; <?= date('Y') ?> <strong>Cashflow CMS</strong>. Developed by <strong>Engr. Avela Nder Marcel</strong> | <strong>NderTech Universal Services</strong>.
        </div>
        <div>
            Activity Logging Module
        </div>
    </footer>

</div>