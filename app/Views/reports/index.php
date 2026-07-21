<style>
    :root {
        --primary-color: #2563eb;
        --success-color: #16a34a;
        --warning-color: #d97706;
        --danger-color: #dc2626;
        --info-color: #0891b2;
        --bg-card: #ffffff;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
    }

    .report-container {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        color: var(--text-dark);
        padding: 24px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Page Header Bar */
    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 24px;
        gap: 16px;
    }
    .report-header h2 {
        margin: 0 0 4px 0;
        font-size: 1.5rem;
        font-weight: 700;
    }
    .report-header p {
        margin: 0;
        color: var(--text-muted);
        font-size: 0.875rem;
    }

    .header-actions {
        display: flex;
        gap: 8px;
        flex-wrap: wrap;
    }

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

    .btn-dashboard {
        background-color: #f1f5f9;
        color: var(--text-dark);
        border-color: var(--border-color);
    }
    .btn-dashboard:hover { background-color: #e2e8f0; }

    .btn-logout {
        background-color: #fee2e2;
        color: var(--danger-color);
        border-color: #fca5a5;
    }
    .btn-logout:hover { background-color: #fecaca; }

    .btn-print {
        background-color: var(--primary-color);
        color: white;
    }
    .btn-print:hover { background-color: #1d4ed8; }

    /* Filter Card */
    .filter-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .filter-form {
        display: flex;
        gap: 16px;
        align-items: flex-end;
        flex-wrap: wrap;
    }
    .form-group {
        display: flex;
        flex-direction: column;
        flex: 1;
        min-width: 180px;
    }
    .form-group label {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-muted);
        margin-bottom: 6px;
    }
    .form-control {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 0.875rem;
    }
    .btn-submit {
        background-color: var(--primary-color);
        color: white;
        border: none;
        padding: 9px 18px;
        border-radius: 6px;
        cursor: pointer;
        font-weight: 600;
    }
    .btn-reset {
        background-color: transparent;
        color: var(--text-muted);
        border: 1px solid var(--border-color);
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        text-align: center;
        font-size: 0.875rem;
    }

    /* Section Labels */
    .section-title {
        font-size: 1rem;
        font-weight: 700;
        margin: 24px 0 12px 0;
        color: var(--text-dark);
    }

    /* KPI Grid */
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
    .kpi-card.success { border-left-color: var(--success-color); }
    .kpi-card.warning { border-left-color: var(--warning-color); }
    .kpi-card.danger { border-left-color: var(--danger-color); }
    .kpi-card.info { border-left-color: var(--info-color); }

    .kpi-title {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-muted);
    }
    .kpi-value {
        font-size: 1.4rem;
        font-weight: 700;
        margin: 6px 0;
    }
    .kpi-subtext {
        font-size: 0.75rem;
        color: var(--text-muted);
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
    .table-header {
        padding: 16px;
        border-bottom: 1px solid var(--border-color);
        background-color: #f8fafc;
    }
    .table-header h3 {
        margin: 0;
        font-size: 1rem;
        font-weight: 700;
    }

    .report-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 0.875rem;
    }
    .report-table th {
        background-color: #f1f5f9;
        padding: 12px 16px;
        font-weight: 600;
        color: var(--text-muted);
        border-bottom: 1px solid var(--border-color);
    }
    .report-table td {
        padding: 12px 16px;
        border-bottom: 1px solid var(--border-color);
    }
    .report-table tr:hover { background-color: #f8fafc; }

    /* Badges */
    .badge {
        display: inline-block;
        padding: 4px 8px;
        border-radius: 4px;
        font-size: 0.75rem;
        font-weight: 600;
    }
    .badge-deposit { background-color: #dcfce7; color: #15803d; }
    .badge-withdrawal { background-color: #fef3c7; color: #b45309; }
    .badge-expense { background-color: #fee2e2; color: #b91c1c; }

    .text-success { color: var(--success-color); font-weight: 600; }
    .text-danger { color: var(--danger-color); font-weight: 600; }
    .text-end { text-align: right; }

    /* Footer Branding */
    .report-footer {
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
    .report-footer strong {
        color: var(--text-dark);
    }
</style>

<div class="report-container">

    <!-- PAGE HEADER -->
    <div class="report-header">
        <div>
            <h2>Financial Reports & Analytics</h2>
            <p>Overview of cashflows, inventory performance, and transaction logs.</p>
        </div>
        <div class="header-actions">
            <a href="<?= base_url('dashboard') ?>" class="btn-action btn-dashboard">
                <i class="fas fa-arrow-left me-1"></i> Dashboard
            </a>
            <button onclick="window.print()" class="btn-action btn-print">
                <i class="fas fa-print me-1"></i> Print Statement
            </button>
            <a href="<?= base_url('logout') ?>" class="btn-action btn-logout">
                <i class="fas fa-right-from-bracket me-1"></i> Logout
            </a>
        </div>
    </div>

    <!-- DATE FILTER FORM -->
    <div class="filter-card">
        <form method="GET" action="<?= base_url('reports') ?>" class="filter-form">
            <div class="form-group">
                <label>From Date</label>
                <input type="date" name="start_date" class="form-control" value="<?= htmlspecialchars($startDate) ?>" required>
            </div>
            <div class="form-group">
                <label>To Date</label>
                <input type="date" name="end_date" class="form-control" value="<?= htmlspecialchars($endDate) ?>" required>
            </div>
            <div style="display: flex; gap: 8px;">
                <button type="submit" class="btn-submit">Filter</button>
                <a href="<?= base_url('reports') ?>" class="btn-reset">Reset</a>
            </div>
        </form>
    </div>

    <!-- ITEMS & INVENTORY SUMMARY CARDS -->
    <div class="section-title">Items & Inventory Valuation</div>
    <div class="kpi-grid">
        <div class="kpi-card info">
            <div class="kpi-title">Stock Buying Valuation</div>
            <div class="kpi-value">₦<?= number_format($summary['inventory_cost'], 2) ?></div>
            <div class="kpi-subtext">Capital tied up in current inventory</div>
        </div>

        <div class="kpi-card success">
            <div class="kpi-title">Stock Retail Valuation</div>
            <div class="kpi-value text-success">₦<?= number_format($summary['inventory_retail'], 2) ?></div>
            <div class="kpi-subtext">Potential revenue on 100% sales</div>
        </div>

        <?php $expectedMargin = $summary['inventory_retail'] - $summary['inventory_cost']; ?>
        <div class="kpi-card">
            <div class="kpi-title">Projected Inventory Margin</div>
            <div class="kpi-value <?= $expectedMargin >= 0 ? 'text-success' : 'text-danger' ?>">
                ₦<?= number_format($expectedMargin, 2) ?>
            </div>
            <div class="kpi-subtext">Unrealized profit margin</div>
        </div>
    </div>

    <!-- CASHFLOW OVERVIEW CARDS -->
    <div class="section-title">Cashflow Summary</div>
    <div class="kpi-grid">
        <div class="kpi-card success">
            <div class="kpi-title">Total Deposits</div>
            <div class="kpi-value text-success">₦<?= number_format($summary['total_deposits'], 2) ?></div>
            <div class="kpi-subtext">Total inflows for period</div>
        </div>

        <div class="kpi-card warning">
            <div class="kpi-title">Total Withdrawals</div>
            <div class="kpi-value" style="color: var(--warning-color);">₦<?= number_format($summary['total_withdrawals'], 2) ?></div>
            <div class="kpi-subtext">Outflow transfers</div>
        </div>

        <div class="kpi-card danger">
            <div class="kpi-title">Total Expenses</div>
            <div class="kpi-value text-danger">₦<?= number_format($summary['total_expenses'], 2) ?></div>
            <div class="kpi-subtext">Operating expenditures</div>
        </div>

        <div class="kpi-card <?= $summary['net_cashflow'] >= 0 ? '' : 'danger' ?>">
            <div class="kpi-title">Net Cashflow Balance</div>
            <div class="kpi-value <?= $summary['net_cashflow'] >= 0 ? 'text-success' : 'text-danger' ?>">
                ₦<?= number_format($summary['net_cashflow'], 2) ?>
            </div>
            <div class="kpi-subtext">Deposits - (Withdrawals + Expenses)</div>
        </div>
    </div>

    <!-- UNIFIED TRANSACTIONS LEDGER TABLE -->
    <div class="table-card">
        <div class="table-header">
            <h3>Unified Cashflow Ledger</h3>
        </div>
        <div style="overflow-x: auto;">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Date & Time</th>
                        <th>Type</th>
                        <th>Reference / Category</th>
                        <th>Description</th>
                        <th class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($ledger)): ?>
                        <tr>
                            <td colspan="6" style="text-align: center; color: var(--text-muted); padding: 24px;">
                                No transactions recorded for the selected date range.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($ledger as $idx => $entry): ?>
                            <tr>
                                <td><?= $idx + 1 ?></td>
                                <td><?= date('d M, Y h:i A', strtotime($entry['created_at'])) ?></td>
                                <td>
                                    <?php if ($entry['type'] === 'deposit'): ?>
                                        <span class="badge badge-deposit">Deposit</span>
                                    <?php elseif ($entry['type'] === 'withdrawal'): ?>
                                        <span class="badge badge-withdrawal">Withdrawal</span>
                                    <?php else: ?>
                                        <span class="badge badge-expense">Expense</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= htmlspecialchars($entry['reference'] ?? '-') ?></td>
                                <td><?= htmlspecialchars($entry['description'] ?? '-') ?></td>
                                <td class="text-end <?= $entry['type'] === 'deposit' ? 'text-success' : 'text-danger' ?>">
                                    <?= $entry['type'] === 'deposit' ? '+' : '-' ?>₦<?= number_format((float)$entry['amount'], 2) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- SYSTEM FOOTER -->
    <footer class="report-footer">
        <div>
            &copy; <?= date('Y') ?> <strong>Cashflow CMS</strong>. Developed by <strong>Engr. Avela Nder Marcel</strong> | <strong>NderTech Universal Services</strong>.
        </div>
        <div>
            Generated on <?= date('d M, Y h:i A') ?>
        </div>
    </footer>

</div>