<?php

declare(strict_types=1);

?>

<!-- Expense Statistics -->

<div class="row g-4 mb-4">


    <!-- Total Expenses -->

    <div class="col-xl-4 col-md-6">

        <div
            class="card
            expense-stat-card
            expense-stat-total
            h-100"
        >

            <div class="card-body">

                <div
                    class="d-flex
                    justify-content-between
                    align-items-center"
                >

                    <div>

                        <span
                            class="expense-stat-label"
                        >

                            Total Expenses

                        </span>


                        <div
                            class="expense-stat-value"
                        >

                            ₦<?= number_format(
                                (float)
                                $totalExpenses,
                                2
                            ) ?>

                        </div>

                    </div>


                    <div
                        class="expense-stat-icon"
                    >

                        <i
                            class="fas
                            fa-money-bill-wave"
                        ></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Today's Expenses -->

    <div class="col-xl-4 col-md-6">

        <div
            class="card
            expense-stat-card
            expense-stat-today
            h-100"
        >

            <div class="card-body">

                <div
                    class="d-flex
                    justify-content-between
                    align-items-center"
                >

                    <div>

                        <span
                            class="expense-stat-label"
                        >

                            Today's Expenses

                        </span>


                        <div
                            class="expense-stat-value"
                        >

                            ₦<?= number_format(
                                (float)
                                $todayTotalExpenses,
                                2
                            ) ?>

                        </div>

                    </div>


                    <div
                        class="expense-stat-icon"
                    >

                        <i
                            class="fas
                            fa-calendar-day"
                        ></i>

                    </div>

                </div>

            </div>

        </div>

    </div>


    <!-- Total Records -->

    <div class="col-xl-4 col-md-6">

        <div
            class="card
            expense-stat-card
            expense-stat-records
            h-100"
        >

            <div class="card-body">

                <div
                    class="d-flex
                    justify-content-between
                    align-items-center"
                >

                    <div>

                        <span
                            class="expense-stat-label"
                        >

                            Total Records

                        </span>


                        <div
                            class="expense-stat-value"
                        >

                            <?= number_format(
                                count(
                                    $expenses
                                )
                            ) ?>

                        </div>

                    </div>


                    <div
                        class="expense-stat-icon"
                    >

                        <i
                            class="fas
                            fa-receipt"
                        ></i>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>