<div class="row g-4 mb-4">

    <!-- Total Customers -->
    <div class="col-xl-3 col-md-6">

        <div class="stats-card customers">

            <div>

                <small>Total Customers</small>

                <h3><?= number_format($stats['total']) ?></h3>

                <span>

                    <i class="fas fa-users"></i>

                    Registered Customers

                </span>

            </div>

            <i class="fas fa-users"></i>

        </div>

    </div>

    <!-- Active -->
    <div class="col-xl-3 col-md-6">

        <div class="stats-card deposits">

            <div>

                <small>Active Customers</small>

                <h3><?= number_format($stats['active']) ?></h3>

                <span class="text-success">

                    <i class="fas fa-circle-check"></i>

                    Active

                </span>

            </div>

            <i class="fas fa-user-check"></i>

        </div>

    </div>

    <!-- Inactive -->
    <div class="col-xl-3 col-md-6">

        <div class="stats-card withdrawals">

            <div>

                <small>Inactive Customers</small>

                <h3><?= number_format($stats['inactive']) ?></h3>

                <span class="text-danger">

                    <i class="fas fa-user-slash"></i>

                    Inactive

                </span>

            </div>

            <i class="fas fa-user-xmark"></i>

        </div>

    </div>

    <!-- New This Month -->
    <div class="col-xl-3 col-md-6">

        <div class="stats-card expenses">

            <div>

                <small>New This Month</small>

                <h3><?= number_format($stats['monthly']) ?></h3>

                <span>

                    <i class="fas fa-arrow-trend-up"></i>

                    This Month

                </span>

            </div>

            <i class="fas fa-user-plus"></i>

        </div>

    </div>

</div>