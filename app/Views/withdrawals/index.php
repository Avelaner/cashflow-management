<?php

use App\Services\PermissionService;

?>

<div class="container-fluid withdrawal-page">

    <!-- Page Header -->
    <div class="withdrawal-page-header mb-4">

        <div>

            <div class="d-flex align-items-center gap-3 mb-2">

                <div class="withdrawal-title-icon">

                    <i class="fas fa-money-bill-transfer"></i>

                </div>

                <div>

                    <h2 class="fw-bold mb-0">

                        Withdrawals

                    </h2>

                    <p class="text-muted mb-0">

                        Manage all customer withdrawal transactions.

                    </p>

                </div>

            </div>

        </div>


        <?php if (
            PermissionService::can(
                'withdrawals.create'
            )
        ): ?>

            <a
                href="<?= base_url(
                    'withdrawals/create'
                ) ?>"
                class="btn btn-primary">

                <i class="fas fa-plus me-2"></i>

                New Withdrawal

            </a>

        <?php endif; ?>

    </div>


    <!-- Alerts -->
    <?php if (
        !empty($_SESSION['success'])
    ): ?>

        <div
            class="alert alert-success alert-dismissible fade show shadow-sm"
            role="alert">

            <i class="fas fa-circle-check me-2"></i>

            <?= htmlspecialchars(
                $_SESSION['success']
            ) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
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
            role="alert">

            <i class="fas fa-circle-exclamation me-2"></i>

            <?= htmlspecialchars(
                $_SESSION['error']
            ) ?>

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

        <?php unset(
            $_SESSION['error']
        ); ?>

    <?php endif; ?>


    <!-- Statistics -->
    <?php require __DIR__ . '/widgets/stats.php'; ?>


    <!-- Filters -->
    <?php require __DIR__ . '/widgets/filters.php'; ?>


    <!-- Withdrawal Table -->
    <div class="card withdrawal-table-card">

        <div class="card-header">

            <div>

                <h5 class="fw-bold mb-1">

                    Withdrawal Transactions

                </h5>

                <small class="text-muted">

                    Showing

                    <?= count(
                        $withdrawals
                    ) ?>

                    of

                    <?= number_format(
                        $total
                    ) ?>

                    transactions

                </small>

            </div>

        </div>


        <div class="table-responsive">

            <table
                class="table align-middle withdrawal-table mb-0">

                <thead>

                    <tr>

                        <th>#</th>

                        <th>Customer</th>

                        <th>Account Name</th>

                        <th>Account Number</th>

                        <th>Bank</th>

                        <th>Amount</th>

                        <th>Charges</th>

                        <th>Date</th>

                        <th class="text-center">

                            Actions

                        </th>

                    </tr>

                </thead>


                <tbody>

                <?php if (
                    !empty($withdrawals)
                ): ?>

                    <?php foreach (
                        $withdrawals
                        as $index =>
                        $withdrawal
                    ): ?>

                        <tr>

                            <!-- Number -->
                            <td class="text-muted">

                                <?= (
                                    (
                                        $page - 1
                                    )
                                    * $perPage
                                )
                                + $index + 1 ?>

                            </td>


                            <!-- Customer -->
                            <td>

                                <div
                                    class="customer-cell">

                                    <div
                                        class="customer-mini-avatar">

                                        <?= strtoupper(
                                            substr(
                                                $withdrawal[
                                                    'fullname'
                                                ],
                                                0,
                                                1
                                            )
                                        ) ?>

                                    </div>

                                    <div>

                                        <strong>

                                            <?= htmlspecialchars(
                                                $withdrawal[
                                                    'fullname'
                                                ]
                                            ) ?>

                                        </strong>

                                        <small>

                                            <?= htmlspecialchars(
                                                $withdrawal[
                                                    'customer_code'
                                                ]
                                            ) ?>

                                        </small>

                                    </div>

                                </div>

                            </td>


                            <!-- Account Name -->
                            <td>

                                <?= htmlspecialchars(
                                    $withdrawal[
                                        'account_name'
                                    ]
                                    ?? '—'
                                ) ?>

                            </td>


                            <!-- Account Number -->
                            <td>

                                <span
                                    class="account-number">

                                    <?= htmlspecialchars(
                                        $withdrawal[
                                            'account_number'
                                        ]
                                        ?? '—'
                                    ) ?>

                                </span>

                            </td>


                            <!-- Bank -->
                            <td>

                                <span
                                    class="bank-badge">

                                    <i
                                        class="fas fa-building-columns">
                                    </i>

                                    <?= htmlspecialchars(
                                        $withdrawal[
                                            'bank_name'
                                        ]
                                        ?? '—'
                                    ) ?>

                                </span>

                            </td>


                            <!-- Amount -->
                            <td>

                                <strong
                                    class="amount-negative">

                                    ₦<?= number_format(

                                        (float) (
                                            $withdrawal[
                                                'amount'
                                            ]
                                            ?? 0
                                        ),

                                        2

                                    ) ?>

                                </strong>

                            </td>


                            <!-- Charges -->
                            <td>

                                <span
                                    class="charges-amount">

                                    ₦<?= number_format(

                                        (float) (
                                            $withdrawal[
                                                'charges'
                                            ]
                                            ?? 0
                                        ),

                                        2

                                    ) ?>

                                </span>

                            </td>


                            <!-- Date -->
                            <td>

                                <span
                                    class="date-cell">

                                    <i
                                        class="far fa-calendar me-1">
                                    </i>

                                    <?= date(

                                        'd M Y',

                                        strtotime(
                                            $withdrawal[
                                                'transaction_date'
                                            ]
                                        )

                                    ) ?>

                                </span>

                            </td>


                            <!-- Actions -->
                            <td
                                class="text-center">

                                <div
                                    class="withdrawal-actions">


                                    <?php if (
                                        PermissionService::can(
                                            'withdrawals.view'
                                        )
                                    ): ?>

                                        <a
                                            href="<?= base_url(
                                                'withdrawals/show/'
                                                . $withdrawal[
                                                    'id'
                                                ]
                                            ) ?>"
                                            class="btn btn-sm btn-outline-primary"
                                            title="View Withdrawal">

                                            <i
                                                class="fas fa-eye">
                                            </i>

                                        </a>

                                    <?php endif; ?>


                                    <?php if (
                                        PermissionService::can(
                                            'withdrawals.edit'
                                        )
                                    ): ?>

                                        <a
                                            href="<?= base_url(
                                                'withdrawals/edit/'
                                                . $withdrawal[
                                                    'id'
                                                ]
                                            ) ?>"
                                            class="btn btn-sm btn-outline-warning"
                                            title="Edit Withdrawal">

                                            <i
                                                class="fas fa-pen">
                                            </i>

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
                                                    class="fas fa-trash">
                                                </i>

                                            </button>

                                        </form>

                                    <?php endif; ?>


                                </div>

                            </td>

                        </tr>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>

                        <td
                            colspan="9"
                            class="text-center py-5">

                            <div
                                class="empty-withdrawal-state">

                                <i
                                    class="fas fa-money-bill-transfer">
                                </i>

                                <h5>

                                    No withdrawals found

                                </h5>

                                <p
                                    class="text-muted">

                                    No withdrawal transactions match your search.

                                </p>

                            </div>

                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>


        <!-- Pagination -->
        <?php require __DIR__ . '/widgets/pagination.php'; ?>

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