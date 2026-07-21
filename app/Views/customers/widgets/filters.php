<?php

use App\Services\PermissionService;

?>

<div class="card shadow-sm border-0 mb-4">

    <div class="card-body">

        <form method="GET" action="<?= base_url('customers') ?>">

            <div class="row g-3 align-items-end">

                <!-- Search -->
                <div class="col-lg-4">

                    <label class="form-label">
                        Search
                    </label>

                    <input
                        type="text"
                        class="form-control"
                        name="search"
                        placeholder="Name, Phone, Email, Customer Code"
                        value="<?= htmlspecialchars($search ?? '') ?>">

                </div>

                <!-- Status -->
                <div class="col-lg-2">

                    <label class="form-label">
                        Status
                    </label>

                    <select
                        class="form-select"
                        name="status">

                        <option value="">All</option>
                        <option value="Active">Active</option>
                        <option value="Inactive">Inactive</option>

                    </select>

                </div>

                <!-- Gender -->
                <div class="col-lg-2">

                    <label class="form-label">
                        Gender
                    </label>

                    <select
                        class="form-select"
                        name="gender">

                        <option value="">All</option>
                        <option>Male</option>
                        <option>Female</option>

                    </select>

                </div>

                <!-- Search Button -->
                <div class="col-lg-2 d-grid">

                    <button
                        class="btn btn-primary">

                        <i class="fas fa-search me-2"></i>

                        Search

                    </button>

                </div>

                <!-- Reset -->
                <div class="col-lg-2 d-grid">

                    <a
                        href="<?= base_url('customers') ?>"
                        class="btn btn-outline-secondary">

                        <i class="fas fa-rotate-left me-2"></i>

                        Reset

                    </a>

                </div>

            </div>

        </form>

        <hr>

        <div class="d-flex flex-wrap gap-2 justify-content-between">

            <div>

                <?php if (PermissionService::can('customers.create')): ?>

                    <a
                        href="<?= base_url('customers/create') ?>"
                        class="btn btn-success">

                        <i class="fas fa-user-plus me-2"></i>

                        Add Customer

                    </a>

                <?php endif; ?>

            </div>

            <div class="d-flex flex-wrap gap-2">

                <button
                    class="btn btn-outline-success"
                    type="button">

                    <i class="fas fa-file-excel me-2"></i>

                    Excel

                </button>

                <button
                    class="btn btn-outline-danger"
                    type="button">

                    <i class="fas fa-file-pdf me-2"></i>

                    PDF

                </button>

                <button
                    class="btn btn-outline-dark"
                    type="button"
                    onclick="window.print();">

                    <i class="fas fa-print me-2"></i>

                    Print

                </button>

            </div>

        </div>

    </div>

</div>