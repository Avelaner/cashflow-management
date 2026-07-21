<div class="row g-4 mb-4">

    <!-- Total Transactions -->
    <div class="col-xl-3 col-md-6">

        <div class="deposit-stat-card total">

            <div class="stat-content">

                <span class="stat-label">
                    Total Deposits
                </span>

                <h3>
                    <?= number_format(
                        (int) ($stats['total'] ?? 0)
                    ) ?>
                </h3>

                <small>
                    <i class="fas fa-receipt me-1"></i>
                    All transactions
                </small>

            </div>

            <div class="stat-icon">

                <i class="fas fa-money-bill-transfer"></i>

            </div>

        </div>

    </div>


    <!-- Total Amount -->
    <div class="col-xl-3 col-md-6">

        <div class="deposit-stat-card amount">

            <div class="stat-content">

                <span class="stat-label">
                    Total Amount
                </span>

                <h3>

                    ₦<?= number_format(
                        (float) (
                            $stats['total_amount']
                            ?? 0
                        ),
                        2
                    ) ?>

                </h3>

                <small>
                    <i class="fas fa-arrow-trend-up me-1"></i>
                    Total deposited
                </small>

            </div>

            <div class="stat-icon">

                <i class="fas fa-naira-sign"></i>

            </div>

        </div>

    </div>


    <!-- Total Charges -->
    <div class="col-xl-3 col-md-6">

        <div class="deposit-stat-card charges">

            <div class="stat-content">

                <span class="stat-label">
                    Total Charges
                </span>

                <h3>

                    ₦<?= number_format(
                        (float) (
                            $stats['total_charges']
                            ?? 0
                        ),
                        2
                    ) ?>

                </h3>

                <small>
                    <i class="fas fa-receipt me-1"></i>
                    Processing charges
                </small>

            </div>

            <div class="stat-icon">

                <i class="fas fa-percent"></i>

            </div>

        </div>

    </div>


    <!-- This Month -->
    <div class="col-xl-3 col-md-6">

        <div class="deposit-stat-card monthly">

            <div class="stat-content">

                <span class="stat-label">
                    This Month
                </span>

                <h3>

                    ₦<?= number_format(
                        (float) (
                            $stats['monthly_amount']
                            ?? 0
                        ),
                        2
                    ) ?>

                </h3>

                <small>
                    <i class="fas fa-calendar-check me-1"></i>
                    Current month
                </small>

            </div>

            <div class="stat-icon">

                <i class="fas fa-chart-line"></i>

            </div>

        </div>

    </div>

</div>