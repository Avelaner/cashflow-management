<div class="row g-4">

    <!-- Customers -->
    <div class="col-xl-3 col-lg-6 col-md-6">

        <div class="stats-card customers">

            <div>

                <small>Total Customers</small>

                <h4><?= number_format($stats['customers']) ?></h4>

                <span>
                    <i class="fas fa-arrow-trend-up"></i>
                    +12% This Month
                </span>

            </div>

            <i class="fas fa-users"></i>

        </div>

    </div>

    <!-- Deposits -->
    <div class="col-xl-3 col-lg-6 col-md-6">

        <div class="stats-card deposits">

            <div>

                <small>Total Deposits</small>

                <h4>

                    ₦<?= number_format($stats['deposits']) ?>

                </h4>

                <span>

                    <i class="fas fa-arrow-trend-up"></i>

                    +8% Today

                </span>

            </div>

            <i class="fas fa-money-bill-transfer"></i>

        </div>

    </div>

    <!-- Withdrawals -->
    <div class="col-xl-3 col-lg-6 col-md-6">

        <div class="stats-card withdrawals">

            <div>

                <small>Total Withdrawals</small>

                <h4>

                    ₦<?= number_format($stats['withdrawals']) ?>

                </h4>

                <span>

                    <i class="fas fa-arrow-trend-down"></i>

                    -2%

                </span>

            </div>

            <i class="fas fa-money-bill-wave"></i>

        </div>

    </div>

    <!-- Expenses -->
    <div class="col-xl-3 col-lg-6 col-md-6">

        <div class="stats-card expenses">

            <div>

                <small>Total Expenses</small>

                <h4>

                    ₦<?= number_format($stats['expenses']) ?>

                </h4>

                <span>

                    <i class="fas fa-arrow-trend-up"></i>

                    +4%

                </span>

            </div>

            <i class="fas fa-wallet"></i>

        </div>

    </div>

</div>