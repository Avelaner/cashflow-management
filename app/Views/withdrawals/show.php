<?php

use App\Services\PermissionService;

?>

<div class="container-fluid withdrawal-page">

    <!-- Header -->
    <div class="withdrawal-page-header mb-4">

        <div>

            <div
                class="d-flex align-items-center gap-3">

                <div
                    class="withdrawal-title-icon">

                    <i
                        class="fas fa-receipt">
                    </i>

                </div>

                <div>

                    <h2
                        class="fw-bold mb-1">

                        Withdrawal Details

                    </h2>

                    <p
                        class="text-muted mb-0">

                        View complete withdrawal transaction information.

                    </p>

                </div>

            </div>

        </div>


        <div
            class="d-flex gap-2">


            <?php if (
                PermissionService::can(
                    'withdrawals.edit'
                )
            ): ?>

                <a
                    href="<?= base_url(
                        'withdrawals/edit/'
                        . $withdrawal['id']
                    ) ?>"
                    class="btn btn-primary">

                    <i
                        class="fas fa-pen me-2">
                    </i>

                    Edit Withdrawal

                </a>

            <?php endif; ?>


            <?php if (
                PermissionService::can(
                    'withdrawals.delete'
                )
            ): ?>

                <form
                    action="<?= base_url(
                        'withdrawals/delete/'
                        . $withdrawal['id']
                    ) ?>"
                    method="POST"
                    class="d-inline"
                    id="deleteWithdrawalForm">

                    <button
                        type="button"
                        class="btn btn-danger"
                        id="deleteWithdrawalBtn">

                        <i
                            class="fas fa-trash me-2">
                        </i>

                        Delete Withdrawal

                    </button>

                </form>

            <?php endif; ?>


            <a
                href="<?= base_url(
                    'withdrawals'
                ) ?>"
                class="btn btn-outline-secondary">

                <i
                    class="fas fa-arrow-left me-2">
                </i>

                Back

            </a>

        </div>

    </div>


    <div
        class="row g-4">


        <!-- Main Information -->
        <div
            class="col-lg-8">

            <div
                class="card border-0 shadow-sm">

                <div
                    class="card-header bg-white p-4">

                    <h5
                        class="fw-bold mb-0">

                        Transaction Information

                    </h5>

                </div>


                <div
                    class="card-body p-4">

                    <div
                        class="row g-4">


                        <!-- Customer -->
                        <div
                            class="col-md-6">

                            <small
                                class="text-muted d-block">

                                Customer

                            </small>

                            <strong>

                                <?= htmlspecialchars(
                                    $withdrawal[
                                        'fullname'
                                    ]
                                ) ?>

                            </strong>

                            <small
                                class="d-block text-muted">

                                <?= htmlspecialchars(
                                    $withdrawal[
                                        'customer_code'
                                    ]
                                ) ?>

                            </small>

                        </div>


                        <!-- Account Name -->
                        <div
                            class="col-md-6">

                            <small
                                class="text-muted d-block">

                                Account Name

                            </small>

                            <strong>

                                <?= htmlspecialchars(
                                    $withdrawal[
                                        'account_name'
                                    ]
                                    ?? '—'
                                ) ?>

                            </strong>

                        </div>


                        <!-- Account Number -->
                        <div
                            class="col-md-6">

                            <small
                                class="text-muted d-block">

                                Account Number

                            </small>

                            <strong
                                class="account-number">

                                <?= htmlspecialchars(
                                    $withdrawal[
                                        'account_number'
                                    ]
                                    ?? '—'
                                ) ?>

                            </strong>

                        </div>


                        <!-- Bank -->
                        <div
                            class="col-md-6">

                            <small
                                class="text-muted d-block">

                                Bank / Financial Institution

                            </small>

                            <strong>

                                <?= htmlspecialchars(
                                    $withdrawal[
                                        'bank_name'
                                    ]
                                    ?? '—'
                                ) ?>

                            </strong>

                        </div>


                        <!-- Date -->
                        <div
                            class="col-md-6">

                            <small
                                class="text-muted d-block">

                                Transaction Date

                            </small>

                            <strong>

                                <?= date(
                                    'd M Y',
                                    strtotime(
                                        $withdrawal[
                                            'transaction_date'
                                        ]
                                    )
                                ) ?>

                            </strong>

                        </div>


                        <!-- Amount -->
                        <div
                            class="col-md-6">

                            <small
                                class="text-muted d-block">

                                Withdrawal Amount

                            </small>

                            <h4
                                class="text-danger fw-bold mb-0">

                                ₦<?= number_format(

                                    (float) (
                                        $withdrawal[
                                            'amount'
                                        ]
                                        ?? 0
                                    ),

                                    2

                                ) ?>

                            </h4>

                        </div>


                        <!-- Charges -->
                        <div
                            class="col-md-6">

                            <small
                                class="text-muted d-block">

                                Charges

                            </small>

                            <strong
                                class="text-danger">

                                ₦<?= number_format(

                                    (float) (
                                        $withdrawal[
                                            'charges'
                                        ]
                                        ?? 0
                                    ),

                                    2

                                ) ?>

                            </strong>

                        </div>


                        <!-- Description -->
                        <div
                            class="col-12">

                            <hr>

                            <small
                                class="text-muted d-block mb-2">

                                Description

                            </small>

                            <p
                                class="mb-0">

                                <?= nl2br(
                                    htmlspecialchars(
                                        $withdrawal[
                                            'description'
                                        ]
                                        ?? 'No description provided.'
                                    )
                                ) ?>

                            </p>

                        </div>


                    </div>

                </div>

            </div>

        </div>


        <!-- Summary -->
        <div
            class="col-lg-4">

            <div
                class="card border-0 shadow-sm">

                <div
                    class="card-header bg-white p-4">

                    <h5
                        class="fw-bold mb-0">

                        Withdrawal Summary

                    </h5>

                </div>


                <div
                    class="card-body p-4">


                    <div
                        class="mb-3">

                        <small
                            class="text-muted d-block">

                            Withdrawal ID

                        </small>

                        <strong>

                            #<?= $withdrawal[
                                'id'
                            ] ?>

                        </strong>

                    </div>


                    <div
                        class="mb-3">

                        <small
                            class="text-muted d-block">

                            Created At

                        </small>

                        <strong>

                            <?= date(

                                'd M Y, h:i A',

                                strtotime(
                                    $withdrawal[
                                        'created_at'
                                    ]
                                )

                            ) ?>

                        </strong>

                    </div>


                    <div
                        class="alert alert-danger">

                        <i
                            class="fas fa-arrow-up-from-bracket me-2">
                        </i>

                        Withdrawal successfully recorded.

                    </div>

                </div>

            </div>

        </div>


    </div>

</div>


<script>

document
    .getElementById(
        'deleteWithdrawalBtn'
    )
    ?.addEventListener(
        'click',
        function () {

            Swal.fire({

                title:
                    'Delete Withdrawal?',

                text:
                    'This withdrawal record will be permanently deleted.',

                icon:
                    'warning',

                showCancelButton:
                    true,

                confirmButtonColor:
                    '#dc3545',

                cancelButtonColor:
                    '#6c757d',

                confirmButtonText:
                    '<i class="fas fa-trash me-2"></i> Yes, Delete',

                cancelButtonText:
                    'Cancel'

            }).then(
                function (result) {

                    if (
                        result.isConfirmed
                    ) {

                        document
                            .getElementById(
                                'deleteWithdrawalForm'
                            )
                            .submit();

                    }

                }
            );

        }
    );

</script>