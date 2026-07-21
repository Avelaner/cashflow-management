<?php
// User Stats Calculations
$totalUsers   = count($users ?? []);
$activeUsers  = count(array_filter($users ?? [], fn($u) => strtolower($u['status'] ?? '') === 'active'));
$blockedUsers = count(array_filter($users ?? [], fn($u) => strtolower($u['status'] ?? '') === 'blocked'));

// Items Sold Stats Calculations (from items table)
// Assumes $items is passed from controller (e.g., $items = Item::getAll())
$totalItems      = count($items ?? []);
$totalQuantitySold = array_reduce($items ?? [], fn($sum, $item) => $sum + (int)($item['quantity_sold'] ?? $item['sold_qty'] ?? $item['total_sold'] ?? 0), 0);
?>

<!-- KPI CARDS GRID (Includes Items Sold) -->
<div class="kpi-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 16px; margin-bottom: 24px;">
    <!-- USER CARDS -->
    <div class="kpi-card" style="background: #fff; border: 1px solid #e2e8f0; border-left: 4px solid #2563eb; border-radius: 8px; padding: 16px;">
        <div class="kpi-title" style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Users</div>
        <div class="kpi-value" style="font-size: 1.5rem; font-weight: 700; color: #2563eb; margin: 4px 0;"><?= number_format($totalUsers) ?></div>
        <div class="kpi-subtext" style="font-size: 0.75rem; color: #64748b;">Registered system users</div>
    </div>

    <div class="kpi-card" style="background: #fff; border: 1px solid #e2e8f0; border-left: 4px solid #16a34a; border-radius: 8px; padding: 16px;">
        <div class="kpi-title" style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Active Users</div>
        <div class="kpi-value" style="font-size: 1.5rem; font-weight: 700; color: #16a34a; margin: 4px 0;"><?= number_format($activeUsers) ?></div>
        <div class="kpi-subtext" style="font-size: 0.75rem; color: #64748b;">Active accounts</div>
    </div>

    <div class="kpi-card" style="background: #fff; border: 1px solid #e2e8f0; border-left: 4px solid #dc2626; border-radius: 8px; padding: 16px;">
        <div class="kpi-title" style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Blocked Users</div>
        <div class="kpi-value" style="font-size: 1.5rem; font-weight: 700; color: #dc2626; margin: 4px 0;"><?= number_format($blockedUsers) ?></div>
        <div class="kpi-subtext" style="font-size: 0.75rem; color: #64748b;">Suspended accounts</div>
    </div>

    <!-- NEW ITEMS SOLD CARDS -->
    <div class="kpi-card" style="background: #fff; border: 1px solid #e2e8f0; border-left: 4px solid #0284c7; border-radius: 8px; padding: 16px;">
        <div class="kpi-title" style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Total Items</div>
        <div class="kpi-value" style="font-size: 1.5rem; font-weight: 700; color: #0284c7; margin: 4px 0;"><?= number_format($totalItems) ?></div>
        <div class="kpi-subtext" style="font-size: 0.75rem; color: #64748b;">Products in database</div>
    </div>

    <div class="kpi-card" style="background: #fff; border: 1px solid #e2e8f0; border-left: 4px solid #9333ea; border-radius: 8px; padding: 16px;">
        <div class="kpi-title" style="font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase;">Items Sold</div>
        <div class="kpi-value" style="font-size: 1.5rem; font-weight: 700; color: #9333ea; margin: 4px 0;"><?= number_format($totalQuantitySold) ?></div>
        <div class="kpi-subtext" style="font-size: 0.75rem; color: #64748b;">Total units sold</div>
    </div>
</div>

<!-- ITEMS SOLD BREAKDOWN TABLE -->
<?php if (!empty($items)): ?>
<div class="table-card" style="background: #fff; border: 1px solid #e2e8f0; border-radius: 8px; overflow: hidden; margin-bottom: 32px;">
    <div style="padding: 16px; border-bottom: 1px solid #e2e8f0; font-weight: 700; font-size: 1rem; color: #1e293b;">
        Item Sales & Inventory Summary
    </div>
    <table style="width: 100%; border-collapse: collapse; font-size: 0.875rem; text-align: left;">
        <thead>
            <tr style="background-color: #f8fafc; color: #64748b; border-bottom: 1px solid #e2e8f0;">
                <th style="padding: 12px 16px;">#</th>
                <th style="padding: 12px 16px;">Item Name</th>
                <th style="padding: 12px 16px;">Price</th>
                <th style="padding: 12px 16px;">Units Sold</th>
                <th style="padding: 12px 16px;">In Stock</th>
                <th style="padding: 12px 16px;">Total Revenue</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $idx => $item): 
                $sold = (int)($item['quantity_sold'] ?? $item['sold_qty'] ?? $item['total_sold'] ?? 0);
                $price = (float)($item['price'] ?? $item['selling_price'] ?? 0);
                $revenue = $sold * $price;
            ?>
                <tr style="border-bottom: 1px solid #e2e8f0;">
                    <td style="padding: 12px 16px;"><?= $idx + 1 ?></td>
                    <td style="padding: 12px 16px;"><strong><?= htmlspecialchars($item['item_name'] ?? $item['name'] ?? 'N/A') ?></strong></td>
                    <td style="padding: 12px 16px;">&#8358;<?= number_format($price, 2) ?></td>
                    <td style="padding: 12px 16px;">
                        <span style="background: #f3e8ff; color: #7e22ce; font-weight: 700; padding: 2px 8px; border-radius: 4px;">
                            <?= number_format($sold) ?>
                        </span>
                    </td>
                    <td style="padding: 12px 16px;"><?= number_format($item['quantity'] ?? $item['stock'] ?? 0) ?></td>
                    <td style="padding: 12px 16px; font-weight: 600; color: #15803d;">&#8358;<?= number_format($revenue, 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>