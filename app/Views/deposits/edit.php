<?php

$bankGroups = require BASE_PATH
    . '/app/Config/NigerianBanks.php';

?>
<div class="container-fluid deposit-page">

    <div class="deposit-page-header mb-4">

        <div>

            <div class="d-flex align-items-center gap-3">

                <div class="deposit-title-icon">

                    <i class="fas fa-pen"></i>

                </div>

                <div>

                    <h2 class="fw-bold mb-1">

                        Edit Deposit

                    </h2>

                    <p class="text-muted mb-0">

                        Update this deposit transaction.

                    </p>

                </div>

            </div>

        </div>

        <a
            href="<?= base_url(
                'deposits/show/'
                . $deposit['id']
            ) ?>"
            class="btn btn-outline-secondary">

            <i class="fas fa-arrow-left me-2"></i>

            Back to Deposit

        </a>

    </div>


    <form
        action="<?= base_url(
            'deposits/update/'
            . $deposit['id']
        ) ?>"
        method="POST">

        <div class="row g-4">

            <div class="col-lg-8">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white p-4">

                        <h5 class="fw-bold mb-0">

                            Transaction Information

                        </h5>

                    </div>

                    <div class="card-body p-4">

                        <div class="row g-4">

                            <!-- Customer -->

                            <div class="col-md-6">

                                <label class="form-label">

                                    Customer

                                </label>

                                <select
                                    name="customer_id"
                                    class="form-select"
                                    required>

                                    <?php foreach (
                                        $customers
                                        as $customer
                                    ): ?>

                                        <option
                                            value="<?= $customer['id'] ?>"
                                            <?= (int) $customer['id']
                                                === (int) $deposit['customer_id']
                                                ? 'selected'
                                                : '' ?>>

                                            <?= htmlspecialchars(
                                                $customer['fullname']
                                            ) ?>

                                            -
                                            <?= htmlspecialchars(
                                                $customer['customer_code']
                                            ) ?>

                                        </option>

                                    <?php endforeach; ?>

                                </select>

                            </div>


                            <!-- Account Name -->

                            <div class="col-md-6">

                                <label class="form-label">

                                    Account Name

                                </label>

                                <input
                                    type="text"
                                    name="account_name"
                                    class="form-control"
                                    value="<?= htmlspecialchars(
                                        $deposit['account_name']
                                    ) ?>"
                                    required>

                            </div>
                            <div class="col-md-6">

    <label class="form-label">

        Account Number

    </label>

    <div class="input-group">

        <span class="input-group-text">

            <i class="fas fa-hashtag"></i>

        </span>

        <input
            type="text"
            name="account_number"
            class="form-control"
            value="<?= htmlspecialchars(
                $deposit['account_number']
                ?? ''
            ) ?>"
            maxlength="50"
            required>

    </div>

</div>


                            <!-- Bank -->

                           <div class="col-md-6">

    <label class="form-label">

        Bank / Microfinance

    </label>

    <select
        name="bank_name"
        class="form-select"
        required>

        <option value="">

            Select Bank / Microfinance

        </option>


        <?php foreach (
            $bankGroups
            as $category => $banks
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
                        ) ?>"
                        <?= $deposit['bank_name']
                            === $bank
                            ? 'selected'
                            : '' ?>>

                        <?= htmlspecialchars(
                            $bank
                        ) ?>

                    </option>

                <?php endforeach; ?>

            </optgroup>

        <?php endforeach; ?>


        <option value="Other"
            <?= $deposit['bank_name']
                === 'Other'
                ? 'selected'
                : '' ?>>

            Other

        </option>

    </select>

</div>


                            <!-- Amount -->

                            <div class="col-md-6">

                                <label class="form-label">

                                    Amount

                                </label>

                                <input
                                    type="number"
                                    name="amount"
                                    class="form-control"
                                    step="0.01"
                                    min="0"
                                    value="<?= htmlspecialchars(
                                        $deposit['amount']
                                    ) ?>"
                                    required>

                            </div>


                            <!-- Charges -->

                            <div class="col-md-6">

                                <label class="form-label">

                                    Charges

                                </label>

                                <input
                                    type="number"
                                    name="charges"
                                    class="form-control"
                                    step="0.01"
                                    min="0"
                                    value="<?= htmlspecialchars(
                                        $deposit['charges']
                                        ?? 0
                                    ) ?>">

                            </div>


                            <!-- Date -->

                            <div class="col-md-6">

                                <label class="form-label">

                                    Transaction Date

                                </label>

                                <input
                                    type="date"
                                    name="transaction_date"
                                    class="form-control"
                                    value="<?= htmlspecialchars(
                                        $deposit[
                                            'transaction_date'
                                        ]
                                    ) ?>"
                                    required>

                            </div>


                            <!-- Description -->

                            <div class="col-12">

                                <label class="form-label">

                                    Description

                                </label>

                                <textarea
                                    name="description"
                                    rows="4"
                                    class="form-control"><?= htmlspecialchars(
                                        $deposit[
                                            'description'
                                        ]
                                        ?? ''
                                    ) ?></textarea>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            <div class="col-lg-4">

                <div class="card border-0 shadow-sm">

                    <div class="card-header bg-white p-4">

                        <h5 class="fw-bold mb-0">

                            Update Deposit

                        </h5>

                    </div>

                    <div class="card-body p-4">

                        <div class="alert alert-warning">

                            <i class="fas fa-circle-info me-2"></i>

                            Review the information carefully before saving.

                        </div>

                        <button
                            type="submit"
                            class="btn btn-primary w-100">

                            <i class="fas fa-save me-2"></i>

                            Update Deposit

                        </button>

                        <a
                            href="<?= base_url(
                                'deposits/show/'
                                . $deposit['id']
                            ) ?>"
                            class="btn btn-outline-secondary w-100 mt-2">

                            Cancel

                        </a>

                    </div>

                </div>

            </div>

        </div>

    </form>

</div>