<?php

use App\Services\PermissionService;

?>

<div class="container-fluid deposit-page">

    <!-- Page Header -->
    <div class="deposit-page-header mb-4">

        <div>

            <div class="d-flex align-items-center gap-3 mb-2">

                <div class="deposit-title-icon">

                    <i class="fas fa-money-bill-transfer"></i>

                </div>

                <div>

                    <h2 class="fw-bold mb-0">

                        Deposits & Transfers

                    </h2>

                    <p class="text-muted mb-0">

                        Manage all customer deposits and transfer transactions.

                    </p>

                </div>

            </div>

        </div>


        <?php if (PermissionService::can('deposits.create')): ?>

            <a
                href="<?= base_url('deposits/create') ?>"
                class="btn btn-primary deposit-add-btn">

                <i class="fas fa-plus me-2"></i>

                New Deposit

            </a>

        <?php endif; ?>

    </div>
    <?php if (!empty($_SESSION['success'])): ?>

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

    <?php unset($_SESSION['success']); ?>

<?php endif; ?>


<?php if (!empty($_SESSION['error'])): ?>

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

    <?php unset($_SESSION['error']); ?>

<?php endif; ?>
<script>

setTimeout(() => {

    document
        .querySelectorAll('.alert')
        .forEach(alert => {

            const bsAlert =
                bootstrap.Alert
                    .getOrCreateInstance(alert);

            bsAlert.close();

        });

}, 5000);

</script>


    <!-- Statistics -->
    <?php require __DIR__ . '/widgets/stats.php'; ?>


    <!-- Search and Filters -->
    <?php require __DIR__ . '/widgets/filters.php'; ?>


    <!-- Deposits Table -->
    <div class="card deposit-table-card">

        <div class="card-header">

            <div>

                <h5 class="fw-bold mb-1">

                    Deposit Transactions

                </h5>

                <small class="text-muted">

                    Showing
                    <?= count($deposits) ?>
                    of
                    <?= number_format($total) ?>
                    transactions

                </small>

            </div>

        </div>


        <div class="table-responsive">

            <table class="table align-middle deposit-table mb-0">

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

                <?php if (!empty($deposits)): ?>

                    <?php foreach ($deposits as $index => $deposit): ?>

                        <tr>

                            <td class="text-muted">

                                <?= (($page - 1) * $perPage)
                                    + $index + 1 ?>

                            </td>


                            <td>

                                <div class="customer-cell">

                                    <div class="customer-mini-avatar">

                                        <?= strtoupper(
                                            substr(
                                                $deposit['fullname'],
                                                0,
                                                1
                                            )
                                        ) ?>

                                    </div>

                                    <div>

                                        <strong>

                                            <?= htmlspecialchars(
                                                $deposit['fullname']
                                            ) ?>

                                        </strong>

                                        <small>

                                            <?= htmlspecialchars(
                                                $deposit['customer_code']
                                            ) ?>

                                        </small>

                                    </div>

                                </div>

                            </td>


                            <td>

                                <?= htmlspecialchars(
                                    $deposit['account_name']
                                ) ?>

                            </td>
                            <td>

                                <span class="account-number">

                                    <?= htmlspecialchars(
                                        $deposit['account_number']
                                        ?? '—'
                                    ) ?>

                                </span>

                            </td>


                            <td>

                                <span class="bank-badge">

                                    <i class="fas fa-building-columns"></i>

                                    <?= htmlspecialchars(
                                        $deposit['bank_name']
                                    ) ?>

                                </span>

                            </td>


                            <td>

                                <strong class="amount-positive">

                                    ₦<?= number_format(
                                        (float) $deposit['amount'],
                                        2
                                    ) ?>

                                </strong>

                            </td>


                            <td>

                                <span class="charges-amount">

                                    ₦<?= number_format(
                                        (float) $deposit['charges'],
                                        2
                                    ) ?>

                                </span>

                            </td>


                            <td>

                                <span class="date-cell">

                                    <i class="far fa-calendar me-1"></i>

                                    <?= date(
                                        'd M Y',
                                        strtotime(
                                            $deposit['transaction_date']
                                        )
                                    ) ?>

                                </span>

                            </td>


                            <td class="text-center">

    <div class="deposit-actions">

        <?php if (
            PermissionService::can('deposits.view')
        ): ?>

            <a
                href="<?= base_url(
                    'deposits/show/'
                    . $deposit['id']
                ) ?>"
                class="btn btn-sm btn-outline-primary"
                title="View Deposit">

                <i class="fas fa-eye"></i>

            </a>

        <?php endif; ?>


        <?php if (
            PermissionService::can('deposits.edit')
        ): ?>

            <a
                href="<?= base_url(
                    'deposits/edit/'
                    . $deposit['id']
                ) ?>"
                class="btn btn-sm btn-outline-warning"
                title="Edit Deposit">

                <i class="fas fa-pen"></i>

            </a>

        <?php endif; ?>


       <?php if (
    PermissionService::can('deposits.delete')
): ?>

    <form
        action="<?= base_url(
            'deposits/delete/'
            . $deposit['id']
        ) ?>"
        method="POST"
        class="d-inline"
        id="deleteDepositForm<?= $deposit['id'] ?>">

        <button
            type="button"
            class="btn btn-sm btn-outline-danger"
            title="Delete Deposit"
            onclick="confirmDeleteDeposit(
                <?= $deposit['id'] ?>
            )">

            <i class="fas fa-trash"></i>

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
                            colspan="8"
                            class="text-center py-5">

                            <div class="empty-deposit-state">

                                <i class="fas fa-money-bill-transfer"></i>

                                <h5>

                                    No deposits found

                                </h5>

                                <p class="text-muted">

                                    No deposit transactions match your search.

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

function confirmDeleteDeposit(id)
{
    Swal.fire({

        title: 'Delete Deposit?',

        text:
            'This deposit record will be permanently deleted.',

        icon: 'warning',

        showCancelButton: true,

        confirmButtonColor: '#dc3545',

        cancelButtonColor: '#6c757d',

        confirmButtonText:
            '<i class="fas fa-trash me-2"></i> Yes, Delete',

        cancelButtonText:
            'Cancel'

    }).then((result) => {

        if (result.isConfirmed) {

            document
                .getElementById(
                    'deleteDepositForm' + id
                )
                .submit();

        }

    });

}

</script>