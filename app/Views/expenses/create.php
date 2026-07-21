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

                    <i class="fas fa-receipt"></i>

                </div>

                <div>

                    <h2 class="fw-bold mb-0">

                        Add Expense

                    </h2>

                    <p class="text-muted mb-0">

                        Record a new business expense.

                    </p>

                </div>

            </div>

        </div>


        <a
            href="<?= base_url(
                'expenses'
            ) ?>"
            class="btn btn-outline-secondary"
        >

            <i class="fas fa-arrow-left me-2"></i>

            Back to Expenses

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
            'expenses.create'
        )
    ): ?>

        <!-- Expense Form -->

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
                                'expenses/store'
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


                                        <option
                                            value="Rent"
                                        >

                                            Rent

                                        </option>


                                        <option
                                            value="Salary"
                                        >

                                            Salary

                                        </option>


                                        <option
                                            value="Utilities"
                                        >

                                            Utilities

                                        </option>


                                        <option
                                            value="Transportation"
                                        >

                                            Transportation

                                        </option>


                                        <option
                                            value="Office Supplies"
                                        >

                                            Office Supplies

                                        </option>


                                        <option
                                            value="Maintenance"
                                        >

                                            Maintenance

                                        </option>


                                        <option
                                            value="Marketing"
                                        >

                                            Marketing

                                        </option>


                                        <option
                                            value="Other"
                                        >

                                            Other

                                        </option>

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
                                        placeholder="0.00"
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


                                        <option
                                            value="Cash"
                                        >

                                            Cash

                                        </option>


                                        <option
                                            value="Bank Transfer"
                                        >

                                            Bank Transfer

                                        </option>


                                        <option
                                            value="POS"
                                        >

                                            POS

                                        </option>


                                        <option
                                            value="Card"
                                        >

                                            Card

                                        </option>


                                        <option
                                            value="Other"
                                        >

                                            Other

                                        </option>

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
                                        value="<?= date(
                                            'Y-m-d'
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
                                    ></textarea>

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
                                                'expenses'
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

                                            Save Expense

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

                            Expense Information

                        </h5>

                    </div>


                    <div class="card-body">

                        <p class="text-muted">

                            Record all business expenses accurately
                            to maintain a clear picture of your
                            company's cash flow.

                        </p>


                        <ul class="text-muted">

                            <li class="mb-2">

                                Select the appropriate expense
                                category.

                            </li>


                            <li class="mb-2">

                                Enter the exact amount paid.

                            </li>


                            <li class="mb-2">

                                Select how the expense was paid.

                            </li>


                            <li class="mb-2">

                                Select the actual date of the expense.

                            </li>


                            <li>

                                Add a description for future
                                reference.

                            </li>

                        </ul>

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

            You do not have permission to create expenses.

        </div>

    <?php endif; ?>

</div>