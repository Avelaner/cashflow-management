<?php

use App\Services\PermissionService;

?>

<div class="dashboard-card">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>

            <h5 class="fw-bold mb-1">

                Quick Actions

            </h5>

            <small class="text-muted">

                Frequently used shortcuts

            </small>

        </div>

    </div>

    <div class="row g-3">

        <?php if (PermissionService::can('customers.create')): ?>

        <div class="col-6 col-md-4">

            <a href="<?= base_url('customers/create') ?>" class="quick-action-card">

                <i class="fas fa-user-plus"></i>

                <span>Add Customer</span>

            </a>

        </div>

        <?php endif; ?>


        <?php if (PermissionService::can('deposits.create')): ?>

        <div class="col-6 col-md-4">

            <a href="<?= base_url('deposits/create') ?>" class="quick-action-card">

                <i class="fas fa-money-bill-transfer"></i>

                <span>New Deposit</span>

            </a>

        </div>

        <?php endif; ?>


        <?php if (PermissionService::can('withdrawals.create')): ?>

        <div class="col-6 col-md-4">

            <a href="<?= base_url('withdrawals/create') ?>" class="quick-action-card">

                <i class="fas fa-money-bill-wave"></i>

                <span>Withdrawal</span>

            </a>

        </div>

        <?php endif; ?>


        <?php if (PermissionService::can('expenses.create')): ?>

        <div class="col-6 col-md-4">

            <a href="<?= base_url('expenses/create') ?>" class="quick-action-card">

                <i class="fas fa-wallet"></i>

                <span>Add Expense</span>

            </a>

        </div>

        <?php endif; ?>


        <?php if (PermissionService::can('items.create')): ?>

        <div class="col-6 col-md-4">

            <a href="<?= base_url('items/create') ?>" class="quick-action-card">

                <i class="fas fa-box-open"></i>

                <span>Add Item</span>

            </a>

        </div>

        <?php endif; ?>


        <?php if (PermissionService::can('reports.view')): ?>

        <div class="col-6 col-md-4">

            <a href="<?= base_url('reports') ?>" class="quick-action-card">

                <i class="fas fa-chart-line"></i>

                <span>Reports</span>

            </a>

        </div>

        <?php endif; ?>


        <?php if (PermissionService::can('users.create')): ?>

        <div class="col-6 col-md-4">

            <a href="<?= base_url('users/create') ?>" class="quick-action-card">

                <i class="fas fa-user-shield"></i>

                <span>Add User</span>

            </a>

        </div>

        <?php endif; ?>


        <?php if (PermissionService::can('settings.view')): ?>

        <div class="col-6 col-md-4">

            <a href="<?= base_url('settings') ?>" class="quick-action-card">

                <i class="fas fa-gears"></i>

                <span>Settings</span>

            </a>

        </div>

        <?php endif; ?>

    </div>

</div>