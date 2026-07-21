<?php

declare(strict_types=1);

use App\Services\PermissionService;

?>

<div class="container-fluid expense-page">

    <!-- Page Header -->

    <div
        class="d-flex
        justify-content-between
        align-items-center
        mb-4"
    >

        <div>

            <div
                class="d-flex
                align-items-center
                gap-3
                mb-2"
            >

                <div class="expense-title-icon">

                    <i class="fas fa-pen"></i>

                </div>

                <div>

                    <h2 class="fw-bold mb-0">

                        Edit Expense

                    </h2>

                    <p class="text-muted mb-0">

                        Update the expense information below.

                    </p>

                </div>

            </div>

        </div>


        <a
            href="<?= base_url(
                'expenses/show/'
                . $expense['id']
            ) ?>"
            class="btn btn-outline-secondary"
        >

            <i class="fas fa-arrow-left me-2"></i>

            Back to Expense

        </a>

    </div>


    <!-- Alerts -->

    <?php if (
        !empty(
            $_SESSION['success']
        )
    ): ?>

        <div
            class="alert
            alert-success
            alert-dismissible
            fade
            show
            shadow-sm"
            role="alert"
        >

            <i
                class="fas
                fa-circle-check
                me-2"
            ></i>

            <?= htmlspecialchars(
                $_SESSION['success']
            ) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            >
            </button>

        </div>

        <?php unset(
            $_SESSION['success']
        ); ?>

    <?php endif; ?>


    <?php if (
        !empty(
            $_SESSION['error']
        )
    ): ?>

        <div
            class="alert
            alert-danger
            alert-dismissible
            fade
            show
            shadow-sm"
            role="alert"
        >

            <i
                class="fas
                fa-circle-exclamation
                me-2"
            ></i>

            <?= htmlspecialchars(
                $_SESSION['error']
            ) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert"
            >
            </button>

        </div>

        <?php unset(
            $_SESSION['error']
        ); ?>

    <?php endif; ?>


    <?php if (
        PermissionService::can(
            'expenses.edit'
        )
    ): ?>

        <!-- Edit Expense Form -->

        <div class="row g-4">

            <div class="col-lg-8">

                <div class="card expense-form-card">

                    <div class="card-header">

                        <h5 class="fw-bold mb-0">

                            Expense Information

                        </h5>

                    </div>


                    <div class="card-body">

                        <form
                            action="<?= base_url(
                                'expenses/update/'
                                . $expense['id']
                            ) ?>"
                            method="POST"
                        >

                            <div class="row g-3">


                                <!-- Category -->

                                <div class="col-md-6">

                                    <label
                                        for="category"
                                        class="form-label"
                                    >

                                        Category

                                        <span
                                            class="text-danger"
                                        >
                                            *
                                        </span>

                                    </label>


                                    <?php

                                    $categories = [

                                        'Rent',

                                        'Salary',

                                        'Utilities',

                                        'Transportation',

                                        'Office Supplies',

                                        'Maintenance',

                                        'Marketing',

                                        'Other',

                                    ];

                                    ?>


                                    <select
                                        name="category"
                                        id="category"
                                        class="form-select"
                                        required
                                    >

                                        <option
                                            value=""
                                        >

                                            Select Category

                                        </option>


                                        <?php foreach (
                                            $categories
                                            as $category
                                        ): ?>

                                            <option
                                                value="<?= htmlspecialchars(
                                                    $category
                                                ) ?>"
                                                <?= (
                                                    (
                                                        $expense[
                                                            'category'
                                                        ]
                                                        ?? ''
                                                    )
                                                    === $category
                                                )
                                                    ? 'selected'
                                                    : ''
                                                ?>
                                            >

                                                <?= htmlspecialchars(
                                                    $category
                                                ) ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>


                                <!-- Amount -->

                                <div class="col-md-6">

                                    <label
                                        for="amount"
                                        class="form-label"
                                    >

                                        Amount (₦)

                                        <span
                                            class="text-danger"
                                        >
                                            *
                                        </span>

                                    </label>


                                    <input
                                        type="number"
                                        name="amount"
                                        id="amount"
                                        class="form-control"
                                        min="0.01"
                                        step="0.01"
                                        value="<?= htmlspecialchars(
                                            (string) (
                                                $expense[
                                                    'amount'
                                                ]
                                                ?? ''
                                            )
                                        ) ?>"
                                        required
                                    >

                                </div>


                                <!-- Payment Method -->

                                <div class="col-md-6">

                                    <label
                                        for="payment_method"
                                        class="form-label"
                                    >

                                        Payment Method

                                        <span
                                            class="text-danger"
                                        >
                                            *
                                        </span>

                                    </label>


                                    <?php

                                    $paymentMethods = [

                                        'Cash',

                                        'Bank Transfer',

                                        'POS',

                                        'Card',

                                        'Other',

                                    ];

                                    ?>


                                    <select
                                        name="payment_method"
                                        id="payment_method"
                                        class="form-select"
                                        required
                                    >

                                        <option
                                            value=""
                                        >

                                            Select Payment Method

                                        </option>


                                        <?php foreach (
                                            $paymentMethods
                                            as $method
                                        ): ?>

                                            <option
                                                value="<?= htmlspecialchars(
                                                    $method
                                                ) ?>"
                                                <?= (
                                                    (
                                                        $expense[
                                                            'payment_method'
                                                        ]
                                                        ?? ''
                                                    )
                                                    === $method
                                                )
                                                    ? 'selected'
                                                    : ''
                                                ?>
                                            >

                                                <?= htmlspecialchars(
                                                    $method
                                                ) ?>

                                            </option>

                                        <?php endforeach; ?>

                                    </select>

                                </div>


                                <!-- Transaction Date -->

                                <div class="col-md-6">

                                    <label
                                        for="transaction_date"
                                        class="form-label"
                                    >

                                        Expense Date

                                        <span
                                            class="text-danger"
                                        >
                                            *
                                        </span>

                                    </label>


                                    <input
                                        type="date"
                                        name="transaction_date"
                                        id="transaction_date"
                                        class="form-control"
                                        value="<?= htmlspecialchars(
                                            (string) (
                                                $expense[
                                                    'transaction_date'
                                                ]
                                                ?? ''
                                            )
                                        ) ?>"
                                        required
                                    >

                                </div>


                                <!-- Description -->

                                <div class="col-12">

                                    <label
                                        for="description"
                                        class="form-label"
                                    >

                                        Description

                                    </label>


                                    <textarea
                                        name="description"
                                        id="description"
                                        class="form-control"
                                        rows="4"
                                        placeholder="Enter expense details..."
                                    ><?= htmlspecialchars(
                                        $expense[
                                            'description'
                                        ]
                                        ?? ''
                                    ) ?></textarea>

                                </div>


                                <!-- Buttons -->

                                <div class="col-12">

                                    <hr>


                                    <div
                                        class="d-flex
                                        justify-content-end
                                        gap-2"
                                    >

                                        <a
                                            href="<?= base_url(
                                                'expenses/show/'
                                                . $expense['id']
                                            ) ?>"
                                            class="btn
                                            btn-outline-secondary"
                                        >

                                            Cancel

                                        </a>


                                        <button
                                            type="submit"
                                            class="btn btn-primary"
                                        >

                                            <i
                                                class="fas
                                                fa-save
                                                me-2"
                                            ></i>

                                            Update Expense

                                        </button>

                                    </div>

                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>


            <!-- Information Card -->

            <div class="col-lg-4">

                <div
                    class="card
                    expense-information-card"
                >

                    <div class="card-header">

                        <h5 class="fw-bold mb-0">

                            Record Information

                        </h5>

                    </div>


                    <div class="card-body">


                        <!-- Created At -->

                        <div class="mb-3">

                            <small
                                class="text-muted d-block mb-1"
                            >

                                Created At

                            </small>


                            <?php if (
                                !empty(
                                    $expense[
                                        'created_at'
                                    ]
                                )
                            ): ?>

                                <strong>

                                    <?= date(

                                        'd F Y, h:i A',

                                        strtotime(
                                            $expense[
                                                'created_at'
                                            ]
                                        )

                                    ) ?>

                                </strong>

                            <?php else: ?>

                                <strong>

                                    —

                                </strong>

                            <?php endif; ?>

                        </div>


                        <!-- Recorded By -->

                        <div class="mb-3">

                            <small
                                class="text-muted d-block mb-1"
                            >

                                Recorded By

                            </small>


                            <strong>

                                <?= htmlspecialchars(
                                    $expense[
                                        'created_by_name'
                                    ]
                                    ?? 'System'
                                ) ?>

                            </strong>

                        </div>


                        <!-- Last Updated -->

                        <?php if (
                            !empty(
                                $expense[
                                    'updated_at'
                                ]
                            )
                        ): ?>

                            <div>

                                <small
                                    class="text-muted d-block mb-1"
                                >

                                    Last Updated

                                </small>


                                <strong>

                                    <?= date(

                                        'd F Y, h:i A',

                                        strtotime(
                                            $expense[
                                                'updated_at'
                                            ]
                                        )

                                    ) ?>

                                </strong>

                            </div>

                        <?php endif; ?>

                    </div>

                </div>

            </div>

        </div>


    <?php else: ?>


        <!-- Access Denied -->

        <div
            class="alert
            alert-danger
            shadow-sm"
            role="alert"
        >

            <i
                class="fas
                fa-circle-exclamation
                me-2"
            ></i>

            You do not have permission to edit expenses.

        </div>

    <?php endif; ?>

</div>