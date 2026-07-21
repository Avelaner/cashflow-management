<?php

declare(strict_types=1);

use App\Services\PermissionService;

?>

<div class="container-fluid expense-page">

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <div class="d-flex align-items-center gap-3 mb-2">

                <div class="expense-title-icon">

                    <i class="fas fa-receipt"></i>

                </div>

                <div>

                    <h2 class="fw-bold mb-0">

                        Expense Details

                    </h2>

                    <p class="text-muted mb-0">

                        View complete information about this expense.

                    </p>

                </div>

            </div>

        </div>


        <div class="d-flex gap-2">

            <a
                href="<?= base_url(
                    'expenses'
                ) ?>"
                class="btn btn-outline-secondary"
            >

                <i class="fas fa-arrow-left me-2"></i>

                Back

            </a>


            <?php if (
                PermissionService::can(
                    'expenses.edit'
                )
            ): ?>

                <a
                    href="<?= base_url(
                        'expenses/edit/'
                        . $expense['id']
                    ) ?>"
                    class="btn btn-warning"
                >

                    <i class="fas fa-pen me-2"></i>

                    Edit

                </a>

            <?php endif; ?>

        </div>

    </div>


    <!-- Alerts -->

    <?php if (
        !empty($_SESSION['success'])
    ): ?>

        <div
            class="alert alert-success alert-dismissible fade show shadow-sm"
            role="alert"
        >

            <i class="fas fa-circle-check me-2"></i>

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
        !empty($_SESSION['error'])
    ): ?>

        <div
            class="alert alert-danger alert-dismissible fade show shadow-sm"
            role="alert"
        >

            <i class="fas fa-circle-exclamation me-2"></i>

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


    <div class="row g-4">

        <!-- Main Details -->

        <div class="col-lg-8">

            <div class="card expense-details-card">

                <div class="card-header">

                    <div
                        class="d-flex
                        justify-content-between
                        align-items-center"
                    >

                        <h5 class="fw-bold mb-0">

                            Expense Information

                        </h5>


                        <span class="badge bg-danger">

                            Expense

                        </span>

                    </div>

                </div>


                <div class="card-body">

                    <div class="row g-4">


                        <!-- Category -->

                        <div class="col-md-6">

                            <small
                                class="text-muted d-block mb-1"
                            >

                                Category

                            </small>

                            <strong>

                                <?= htmlspecialchars(
                                    $expense[
                                        'category'
                                    ]
                                ) ?>

                            </strong>

                        </div>


                        <!-- Amount -->

                        <div class="col-md-6">

                            <small
                                class="text-muted d-block mb-1"
                            >

                                Amount

                            </small>

                            <h4
                                class="text-danger
                                fw-bold mb-0"
                            >

                                ₦<?= number_format(

                                    (float) (
                                        $expense[
                                            'amount'
                                        ]
                                        ?? 0
                                    ),

                                    2

                                ) ?>

                            </h4>

                        </div>


                        <!-- Payment Method -->

                        <div class="col-md-6">

                            <small
                                class="text-muted d-block mb-1"
                            >

                                Payment Method

                            </small>

                            <strong>

                                <?= htmlspecialchars(
                                    $expense[
                                        'payment_method'
                                    ]
                                    ?? '—'
                                ) ?>

                            </strong>

                        </div>


                        <!-- Transaction Date -->

                        <div class="col-md-6">

                            <small
                                class="text-muted d-block mb-1"
                            >

                                Expense Date

                            </small>

                            <strong>

                                <?= date(

                                    'd F Y',

                                    strtotime(
                                        $expense[
                                            'transaction_date'
                                        ]
                                    )

                                ) ?>

                            </strong>

                        </div>


                        <!-- Description -->

                        <div class="col-12">

                            <small
                                class="text-muted d-block mb-1"
                            >

                                Description

                            </small>


                            <div
                                class="bg-light
                                p-3
                                rounded"
                            >

                                <?php if (
                                    !empty(
                                        $expense[
                                            'description'
                                        ]
                                    )
                                ): ?>

                                    <?= nl2br(
                                        htmlspecialchars(
                                            $expense[
                                                'description'
                                            ]
                                        )
                                    ) ?>

                                <?php else: ?>

                                    <span
                                        class="text-muted"
                                    >

                                        No description provided.

                                    </span>

                                <?php endif; ?>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        <!-- Sidebar -->

        <div class="col-lg-4">


            <!-- Record Information -->

            <div
                class="card
                expense-record-card
                mb-4"
            >

                <div class="card-header">

                    <h5 class="fw-bold mb-0">

                        Record Information

                    </h5>

                </div>


                <div class="card-body">


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


                    <!-- Created At -->

                    <div class="mb-3">

                        <small
                            class="text-muted d-block mb-1"
                        >

                            Created At

                        </small>

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

                    </div>


                    <!-- Updated At -->

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


            <!-- Delete Card -->

            <?php if (
                PermissionService::can(
                    'expenses.delete'
                )
            ): ?>

                <div
                    class="card
                    border-danger
                    expense-delete-card"
                >

                    <div class="card-body">

                        <h6
                            class="text-danger
                            fw-bold"
                        >

                            Delete Expense

                        </h6>


                        <p
                            class="text-muted
                            small"
                        >

                            Deleting this expense is permanent
                            and cannot be undone.

                        </p>


                        <form
                            action="<?= base_url(
                                'expenses/delete/'
                                . $expense['id']
                            ) ?>"
                            method="POST"
                            id="deleteExpenseForm"
                        >

                            <button
                                type="button"
                                class="btn
                                btn-outline-danger
                                w-100"
                                id="deleteExpenseBtn"
                            >

                                <i
                                    class="fas fa-trash me-2"
                                ></i>

                                Delete Expense

                            </button>

                        </form>

                    </div>

                </div>

            <?php endif; ?>

        </div>

    </div>

</div>


<script>

document
    .getElementById(
        'deleteExpenseBtn'
    )
    ?.addEventListener(
        'click',
        function () {

            Swal.fire({

                title:
                    'Delete Expense?',

                text:
                    'This expense will be permanently deleted.',

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
                                'deleteExpenseForm'
                            )
                            .submit();

                    }

                }
            );

        }
    );

</script>