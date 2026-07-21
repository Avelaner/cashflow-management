<?php

use App\Services\PermissionService;

$current = trim(
    str_replace(
        trim(parse_url(base_url(), PHP_URL_PATH), '/'),
        '',
        trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/')
    ),
    '/'
);

?>

<aside id="sidebar">

    <!-- Sidebar Header -->
    <div class="sidebar-header">

        <a href="<?= base_url('dashboard') ?>" class="sidebar-logo text-decoration-none text-white">

            <img
                src="<?= asset('images/logo.png') ?>"
                alt="Logo"
                width="45"
                height="45"
                class="me-2">

            <span>Cashflow CMS</span>

        </a>

    </div>

    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">

        <?php if (PermissionService::can('dashboard.view')): ?>

        <li>

            <a href="<?= base_url('dashboard') ?>"
               class="<?= $current === 'dashboard' ? 'active' : '' ?>">

                <i class="fas fa-house"></i>

                <span>Dashboard</span>

            </a>

        </li>

        <?php endif; ?>


        <?php if (PermissionService::can('customers.view')): ?>

        <li>

            <a href="<?= base_url('customers') ?>"
               class="<?= str_starts_with($current, 'customers') ? 'active' : '' ?>">

                <i class="fas fa-users"></i>

                <span>Customers</span>

            </a>

        </li>

        <?php endif; ?>


        <?php if (PermissionService::can('deposits.view')): ?>

        <li>

            <a href="<?= base_url('deposits') ?>"
               class="<?= str_starts_with($current, 'deposits') ? 'active' : '' ?>">

                <i class="fas fa-money-bill-transfer"></i>

                <span>Deposits / Transfer</span>

            </a>

        </li>

        <?php endif; ?>


       
 <?php if (PermissionService::can('withdrawals.view')): ?>

        <li>

            <a href="<?= base_url('withdrawals') ?>"
               class="<?= str_starts_with($current, 'withdrawals') ? 'active' : '' ?>">

                <i class="fas fa-money-bill-transfer"></i>

                <span>Withdrawals</span>

            </a>

        </li>

        <?php endif; ?>




        <li>

            <a href="<?= base_url('expenses') ?>"
               class="<?= str_starts_with($current, 'expenses') ? 'active' : '' ?>">

                <i class="fas fa-wallet"></i>

                <span>Expenses</span>

            </a>

        </li>

       


        

        <li>

            <a href="<?= base_url('items') ?>"
               class="<?= str_starts_with($current, 'items') ? 'active' : '' ?>">

                <i class="fas fa-box-open"></i>

                <span>Items</span>

            </a>

        </li>

        


        <?php if (PermissionService::can('reports.view')): ?>
<li>
    <a href="<?= base_url('reports') ?>"
       class="<?= str_starts_with($current, 'reports') ? 'active' : '' ?>">
        <i class="fas fa-chart-line"></i>
        <span>Reports</span>
    </a>
</li>
<?php endif; ?>


        <?php if (PermissionService::can('users.view')): ?>

        <li>

            <a href="<?= base_url('users') ?>"
               class="<?= str_starts_with($current, 'users') ? 'active' : '' ?>">

                <i class="fas fa-user-shield"></i>

                <span>User Management</span>

            </a>

        </li>

        <?php endif; ?>


        <?php if (PermissionService::can('activities.view')): ?>

        <li>

            <a href="<?= base_url('activities') ?>"
               class="<?= str_starts_with($current, 'activities') ? 'active' : '' ?>">

                <i class="fas fa-clock-rotate-left"></i>

                <span>Activity Logs</span>

            </a>

        </li>

        <?php endif; ?>


        <?php if (PermissionService::can('settings.view')): ?>

        <li>

            <a href="<?= base_url('settings') ?>"
               class="<?= str_starts_with($current, 'settings') ? 'active' : '' ?>">

                <i class="fas fa-gears"></i>

                <span>System Settings</span>

            </a>

        </li>

        <?php endif; ?>

    </ul>

</aside>