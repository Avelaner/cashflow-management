<?php

use App\Services\PermissionService;

?>

<div class="deposit-filter-card mb-4">

    <form
        method="GET"
        action="<?= base_url('deposits') ?>">

        <div class="row g-3 align-items-end">

            <!-- Search -->
            <div class="col-lg-6">

                <label class="form-label">

                    Search Deposits

                </label>

                <div class="deposit-search-box">

                    <i class="fas fa-search"></i>

                    <input
                        type="text"
                        name="search"
                        value="<?= htmlspecialchars(
                            $search ?? ''
                        ) ?>"
                        class="form-control"
                        placeholder="Search customer, code, account or bank...">

                </div>

            </div>


            <!-- Search -->
            <div class="col-lg-3 d-grid">

                <button
                    type="submit"
                    class="btn btn-primary deposit-search-btn">

                    <i class="fas fa-search me-2"></i>

                    Search

                </button>

            </div>


            <!-- Reset -->
            <div class="col-lg-3 d-grid">

                <a
                    href="<?= base_url('deposits') ?>"
                    class="btn btn-outline-secondary">

                    <i class="fas fa-rotate-left me-2"></i>

                    Reset

                </a>

            </div>

        </div>

    </form>


    <div class="deposit-filter-divider"></div>


    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">

        <div>

            <span class="text-muted">

                <i class="fas fa-filter me-2"></i>

                Search and manage deposit transactions

            </span>

        </div>


        <?php if (
            PermissionService::can(
                'deposits.create'
            )
        ): ?>

            <a
                href="<?= base_url('deposits/create') ?>"
                class="btn btn-success">

                <i class="fas fa-plus me-2"></i>

                New Deposit

            </a>

        <?php endif; ?>

    </div>

</div>