<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Customer Profile Variables
|--------------------------------------------------------------------------
*/

$picture = !empty($customer['picture'])
    ? $customer['picture']
    : 'default.png';

$totalDeposits = (float) (
    $customer['total_deposits'] ?? 0
);

$totalWithdrawals = (float) (
    $customer['total_withdrawals'] ?? 0
);

$totalDepositCharges = (float) (
    $customer['total_deposit_charges'] ?? 0
);

$totalWithdrawalCharges = (float) (
    $customer['total_withdrawal_charges'] ?? 0
);

$totalCharges =
    $totalDepositCharges
    +
    $totalWithdrawalCharges;

$totalTransactions = (int) (
    $customer['transaction_count'] ?? 0
);

?>

<div class="container-fluid customer-page">

```
<!-- =========================
     PAGE HEADER
========================== -->

<div class="customer-page-header mb-4">

    <div>

        <h2 class="fw-bold mb-1">

            Customer Profile

        </h2>


        <p class="text-muted mb-0">

            View customer information and account activity.

        </p>

    </div>


    <div class="d-flex gap-2">

        <a
            href="<?= base_url(
                'customers/edit/' . $customer['id']
            ) ?>"
            class="btn btn-primary">

            <i class="fas fa-pen me-2"></i>

            Edit Customer

        </a>


        <a
            href="<?= base_url('customers') ?>"
            class="btn btn-outline-secondary">

            <i class="fas fa-arrow-left me-2"></i>

            Back

        </a>

    </div>

</div>


<!-- =========================
     MAIN CONTENT
========================== -->

<div class="row g-4">


    <!-- =========================
         CUSTOMER PROFILE
    ========================== -->

    <div class="col-lg-4">

        <div class="card customer-profile-card">

            <div class="card-body text-center">


                <!-- CUSTOMER IMAGE -->

                <img
                    src="<?= asset(
                        'uploads/customers/' . $picture
                    ) ?>"
                    alt="<?= htmlspecialchars(
                        $customer['fullname']
                    ) ?>"
                    class="customer-profile-image">


                <!-- CUSTOMER NAME -->

                <h4 class="fw-bold mt-4 mb-1">

                    <?= htmlspecialchars(
                        $customer['fullname']
                    ) ?>

                </h4>


                <!-- CUSTOMER CODE -->

                <p class="text-muted mb-3">

                    <?= htmlspecialchars(
                        $customer['customer_code']
                    ) ?>

                </p>


                <!-- CUSTOMER STATUS -->

                <?php if (
                    ($customer['status'] ?? '')
                    === 'Active'
                ): ?>

                    <span class="badge bg-success">

                        <i class="fas fa-circle-check me-1"></i>

                        Active

                    </span>

                <?php else: ?>

                    <span class="badge bg-danger">

                        <i class="fas fa-circle-xmark me-1"></i>

                        Inactive

                    </span>

                <?php endif; ?>


                <hr>


                <!-- CONTACT INFORMATION -->

                <div class="customer-contact-list text-start">


                    <!-- PHONE -->

                    <div class="customer-contact-item">

                        <i class="fas fa-phone"></i>


                        <div>

                            <small class="text-muted">

                                Phone

                            </small>


                            <strong>

                                <?= htmlspecialchars(
                                    $customer['phone']
                                    ?? 'Not provided'
                                ) ?>

                            </strong>

                        </div>

                    </div>


                    <!-- EMAIL -->

                    <div class="customer-contact-item">

                        <i class="fas fa-envelope"></i>


                        <div>

                            <small class="text-muted">

                                Email

                            </small>


                            <strong>

                                <?= htmlspecialchars(
                                    $customer['email']
                                    ?? 'Not provided'
                                ) ?>

                            </strong>

                        </div>

                    </div>


                    <!-- ADDRESS -->

                    <div class="customer-contact-item">

                        <i class="fas fa-location-dot"></i>


                        <div>

                            <small class="text-muted">

                                Address

                            </small>


                            <strong>

                                <?= htmlspecialchars(
                                    $customer['address']
                                    ?? 'Not provided'
                                ) ?>

                            </strong>

                        </div>

                    </div>


                    <!-- OCCUPATION -->

                    <div class="customer-contact-item">

                        <i class="fas fa-briefcase"></i>


                        <div>

                            <small class="text-muted">

                                Occupation

                            </small>


                            <strong>

                                <?= htmlspecialchars(
                                    $customer['occupation']
                                    ?? 'Not provided'
                                ) ?>

                            </strong>

                        </div>

                    </div>


                </div>

            </div>

        </div>

    </div>


    <!-- =========================
         ACCOUNT SUMMARY
    ========================== -->

    <div class="col-lg-8">


        <!-- SUMMARY CARDS -->

        <div class="row g-4 mb-4">


            <!-- TOTAL DEPOSITS -->

            <div class="col-xl-3 col-md-6">

                <div class="customer-summary-card deposits">


                    <div>

                        <small>

                            Total Deposits

                        </small>


                        <h5>

                            ₦<?= number_format(
                                $totalDeposits,
                                2
                            ) ?>

                        </h5>

                    </div>


                    <i class="fas fa-arrow-down"></i>


                </div>

            </div>


            <!-- TOTAL WITHDRAWALS -->

            <div class="col-xl-3 col-md-6">

                <div class="customer-summary-card withdrawals">


                    <div>

                        <small>

                            Total Withdrawals

                        </small>


                        <h5>

                            ₦<?= number_format(
                                $totalWithdrawals,
                                2
                            ) ?>

                        </h5>

                    </div>


                    <i class="fas fa-arrow-up"></i>


                </div>

            </div>


            <!-- TOTAL CHARGES -->

            <div class="col-xl-3 col-md-6">

                <div class="customer-summary-card charges">


                    <div>

                        <small>

                            Total Charges

                        </small>


                        <h5>

                            ₦<?= number_format(
                                $totalCharges,
                                2
                            ) ?>

                        </h5>

                    </div>


                    <i class="fas fa-receipt"></i>


                </div>

            </div>


            <!-- TOTAL TRANSACTIONS -->

            <div class="col-xl-3 col-md-6">

                <div class="customer-summary-card transactions">


                    <div>

                        <small>

                            Total Transactions

                        </small>


                        <h5>

                            <?= number_format(
                                $totalTransactions
                            ) ?>

                        </h5>

                    </div>


                    <i class="fas fa-chart-line"></i>


                </div>

            </div>


        </div>


        <!-- =========================
             PERSONAL INFORMATION
        ========================== -->

        <div class="card customer-profile-card">


            <div class="card-header">

                <h5 class="mb-0 fw-bold">

                    <i class="fas fa-user me-2"></i>

                    Personal Information

                </h5>

            </div>


            <div class="card-body">


                <div class="row g-4">


                    <!-- FULL NAME -->

                    <div class="col-md-6">

                        <small class="text-muted d-block">

                            Full Name

                        </small>


                        <strong>

                            <?= htmlspecialchars(
                                $customer['fullname']
                            ) ?>

                        </strong>

                    </div>


                    <!-- GENDER -->

                    <div class="col-md-6">

                        <small class="text-muted d-block">

                            Gender

                        </small>


                        <strong>

                            <?= htmlspecialchars(
                                $customer['gender']
                                ?? 'Not provided'
                            ) ?>

                        </strong>

                    </div>


                    <!-- PHONE -->

                    <div class="col-md-6">

                        <small class="text-muted d-block">

                            Phone Number

                        </small>


                        <strong>

                            <?= htmlspecialchars(
                                $customer['phone']
                                ?? 'Not provided'
                            ) ?>

                        </strong>

                    </div>


                    <!-- EMAIL -->

                    <div class="col-md-6">

                        <small class="text-muted d-block">

                            Email Address

                        </small>


                        <strong>

                            <?= htmlspecialchars(
                                $customer['email']
                                ?? 'Not provided'
                            ) ?>

                        </strong>

                    </div>


                    <!-- OCCUPATION -->

                    <div class="col-md-6">

                        <small class="text-muted d-block">

                            Occupation

                        </small>


                        <strong>

                            <?= htmlspecialchars(
                                $customer['occupation']
                                ?? 'Not provided'
                            ) ?>

                        </strong>

                    </div>


                    <!-- REGISTRATION DATE -->

                    <div class="col-md-6">

                        <small class="text-muted d-block">

                            Registration Date

                        </small>


                        <strong>

                            <?= !empty(
                                $customer['created_at']
                            )

                                ? date(
                                    'd M Y',
                                    strtotime(
                                        $customer['created_at']
                                    )
                                )

                                : 'N/A' ?>

                        </strong>

                    </div>


                    <!-- ADDRESS -->

                    <div class="col-12">

                        <small class="text-muted d-block">

                            Address

                        </small>


                        <strong>

                            <?= htmlspecialchars(
                                $customer['address']
                                ?? 'Not provided'
                            ) ?>

                        </strong>

                    </div>


                </div>

            </div>

        </div>

    </div>

</div>


</div>
