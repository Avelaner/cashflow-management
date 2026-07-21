<?php

$bankGroups = require BASE_PATH
    . '/app/Config/NigerianBanks.php';

?>

<div class="container-fluid withdrawal-create-page">

    <!-- Page Header -->
    <div class="customer-page-header mb-4">

        <div>

            <h2 class="fw-bold mb-1">

                Add Withdrawal

            </h2>

            <p class="text-muted mb-0">

                Record a new customer withdrawal transaction.

            </p>

        </div>

        <a
            href="<?= base_url('withdrawals') ?>"
            class="btn btn-outline-secondary">

            <i class="fas fa-arrow-left me-2"></i>

            Back to Withdrawals

        </a>

    </div>


    <form
        action="<?= base_url(
            'withdrawals/store'
        ) ?>"
        method="POST">


        <div class="row">


            <!-- Main Form -->
            <div class="col-lg-8">

                <div class="card customer-form-card mb-4">

                    <div class="card-header">

                        <div
                            class="d-flex align-items-center gap-3">

                            <div
                                class="form-section-icon">

                                <i
                                    class="fas fa-money-bill-transfer">
                                </i>

                            </div>

                            <div>

                                <h5
                                    class="mb-1 fw-bold">

                                    Withdrawal Information

                                </h5>

                                <small
                                    class="text-muted">

                                    Enter the withdrawal details below.

                                </small>

                            </div>

                        </div>

                    </div>


                    <div class="card-body">

                        <div class="row g-4">


                            <!-- Customer -->
                            <div class="col-md-6">

                                <label
                                    class="form-label">

                                    Customer

                                </label>

                                <select
                                    name="customer_id"
                                    class="form-select"
                                    required>

                                    <option
                                        value="">

                                        Select Customer

                                    </option>

                                    <?php foreach (
                                        $customers
                                        as $customer
                                    ): ?>

                                        <option
                                            value="<?= $customer[
                                                'id'
                                            ] ?>">

                                            <?= htmlspecialchars(
                                                $customer[
                                                    'fullname'
                                                ]
                                            ) ?>

                                            -

                                            <?= htmlspecialchars(
                                                $customer[
                                                    'customer_code'
                                                ]
                                            ) ?>

                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>


                            <!-- Account Name -->
                            <div class="col-md-6">

                                <label
                                    class="form-label">

                                    Account Name

                                </label>

                                <input
                                    type="text"
                                    name="account_name"
                                    class="form-control"
                                    placeholder="e.g. GTBank, Opay, Cash"
                                    required>

                            </div>


                            <!-- Account Number -->
                            <div class="col-md-6">

                                <label
                                    class="form-label">

                                    Account Number

                                </label>

                                <input
                                    type="text"
                                    name="account_number"
                                    class="form-control"
                                    placeholder="Account number">

                            </div>


                            <!-- Bank -->
                            <div class="col-md-6">

                                <label
                                    class="form-label">

                                    Bank / Financial Institution

                                </label>

                                <select
                                    name="bank_name"
                                    class="form-select"
                                    required>

                                    <option
                                        value="">

                                        Select Bank / Microfinance

                                    </option>

                                    <?php foreach (
                                        $bankGroups
                                        as $category =>
                                        $banks
                                    ): ?>

                                        <optgroup
                                            label="<?= htmlspecialchars(
                                                $category
                                            ) ?>">

                                            <?php foreach (
                                                $banks
                                                as $bank
                                            ): ?>

                                                <option
                                                    value="<?= htmlspecialchars(
                                                        $bank
                                                    ) ?>">

                                                    <?= htmlspecialchars(
                                                        $bank
                                                    ) ?>

                                                </option>

                                            <?php endforeach; ?>

                                        </optgroup>

                                    <?php endforeach; ?>

                                    <option
                                        value="Other">

                                        Other

                                    </option>

                                </select>

                            </div>


                            <!-- Amount -->
                            <div class="col-md-6">

                                <label
                                    class="form-label">

                                    Amount

                                </label>

                                <div
                                    class="input-group">

                                    <span
                                        class="input-group-text">

                                        ₦

                                    </span>

                                    <input
                                        type="number"
                                        name="amount"
                                        class="form-control"
                                        min="0"
                                        step="0.01"
                                        placeholder="0.00"
                                        required>

                                </div>

                            </div>


                            <!-- Charges -->
                            <div class="col-md-6">

                                <label
                                    class="form-label">

                                    Charges

                                </label>

                                <div
                                    class="input-group">

                                    <span
                                        class="input-group-text">

                                        ₦

                                    </span>

                                    <input
                                        type="number"
                                        name="charges"
                                        class="form-control"
                                        min="0"
                                        step="0.01"
                                        value="0">

                                </div>

                                <small
                                    class="text-muted">

                                    Bank or transaction charges.

                                </small>

                            </div>


                            <!-- Transaction Date -->
                            <div class="col-md-6">

                                <label
                                    class="form-label">

                                    Transaction Date

                                </label>

                                <input
                                    type="date"
                                    name="transaction_date"
                                    class="form-control"
                                    value="<?= date(
                                        'Y-m-d'
                                    ) ?>"
                                    required>

                            </div>


                            <!-- Description -->
                            <div class="col-12">

                                <label
                                    class="form-label">

                                    Description

                                </label>

                                <textarea
                                    name="description"
                                    rows="4"
                                    class="form-control"
                                    placeholder="Optional withdrawal description..."></textarea>

                            </div>


                        </div>

                    </div>

                </div>


                <!-- Information Card -->
                <div
                    class="customer-info-card">

                    <div
                        class="d-flex gap-3">

                        <i
                            class="fas fa-circle-info">
                        </i>

                        <div>

                            <strong>

                                Withdrawal Information

                            </strong>

                            <p
                                class="mb-0 mt-1">

                                Make sure the customer, account details,
                                amount and transaction date are correct
                                before saving.

                            </p>

                        </div>

                    </div>

                </div>

            </div>


            <!-- Right Column -->
            <div class="col-lg-4">

                <div
                    class="card customer-form-card">

                    <div
                        class="card-header">

                        <h5
                            class="mb-0 fw-bold">

                            Transaction Summary

                        </h5>

                    </div>


                    <div
                        class="card-body">


                        <div
                            class="text-center py-4">

                            <i
                                class="fas fa-arrow-up-from-bracket fa-4x text-danger mb-3">
                            </i>

                            <h5>

                                New Withdrawal

                            </h5>

                            <p
                                class="text-muted">

                                The transaction will be deducted
                                from the customer's account.

                            </p>

                        </div>


                        <hr>


                        <div
                            class="d-grid gap-2">


                            <button
                                type="submit"
                                class="btn btn-danger btn-lg">

                                <i
                                    class="fas fa-save me-2">
                                </i>

                                Save Withdrawal

                            </button>


                            <a
                                href="<?= base_url(
                                    'withdrawals'
                                ) ?>"
                                class="btn btn-outline-secondary">

                                Cancel

                            </a>


                        </div>

                    </div>

                </div>

            </div>


        </div>


    </form>

</div>