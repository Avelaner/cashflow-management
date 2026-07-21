<div class="row g-4 mb-4">

    <!-- Total Withdrawals -->
    <div class="col-xl-3 col-md-6">

        <div class="stat-card withdrawal-stat-card">

            <div class="stat-card-content">

                <div>

                    <span class="stat-label">

                        Total Withdrawals

                    </span>

                    <h3 class="stat-value">

                        <?= number_format(
                            (int) (
                                $stats['total']
                                ?? 0
                            )
                        ) ?>

                    </h3>

                    <small class="text-muted">

                        All withdrawal records

                    </small>

                </div>


                <div class="stat-icon">

                    <i class="fas fa-list"></i>

                </div>

            </div>

        </div>

    </div>


    <!-- Total Amount -->
    <div class="col-xl-3 col-md-6">

        <div class="stat-card withdrawal-stat-card">

            <div class="stat-card-content">

                <div>

                    <span class="stat-label">

                        Total Amount

                    </span>

                    <h3 class="stat-value">

                        ₦<?= number_format(

                            (float) (

                                $stats[
                                    'total_amount'
                                ]

                                ?? 0

                            ),

                            2

                        ) ?>

                    </h3>

                    <small class="text-muted">

                        Total withdrawn

                    </small>

                </div>


                <div class="stat-icon">

                    <i class="fas fa-arrow-up"></i>

                </div>

            </div>

        </div>

    </div>


    <!-- Total Charges -->
    <div class="col-xl-3 col-md-6">

        <div class="stat-card withdrawal-stat-card">

            <div class="stat-card-content">

                <div>

                    <span class="stat-label">

                        Total Charges

                    </span>

                    <h3 class="stat-value">

                        ₦<?= number_format(

                            (float) (

                                $stats[
                                    'total_charges'
                                ]

                                ?? 0

                            ),

                            2

                        ) ?>

                    </h3>

                    <small class="text-muted">

                        Bank and transaction charges

                    </small>

                </div>


                <div class="stat-icon">

                    <i class="fas fa-receipt"></i>

                </div>

            </div>

        </div>

    </div>


    <!-- Monthly Withdrawals -->
    <div class="col-xl-3 col-md-6">

        <div class="stat-card withdrawal-stat-card">

            <div class="stat-card-content">

                <div>

                    <span class="stat-label">

                        This Month

                    </span>

                    <h3 class="stat-value">

                        ₦<?= number_format(

                            (float) (

                                $stats[
                                    'monthly_amount'
                                ]

                                ?? 0

                            ),

                            2

                        ) ?>

                    </h3>

                    <small class="text-muted">

                        Withdrawals this month

                    </small>

                </div>


                <div class="stat-icon">

                    <i class="fas fa-calendar-days"></i>

                </div>

            </div>

        </div>

    </div>

</div>