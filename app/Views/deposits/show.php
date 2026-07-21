<div class="container-fluid deposit-page">
    <?php if (!empty($_SESSION['success'])): ?>

    <div class="alert alert-success alert-dismissible fade show shadow-sm mb-4">

        <i class="fas fa-circle-check me-2"></i>

        <?= htmlspecialchars($_SESSION['success']) ?>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

    <?php unset($_SESSION['success']); ?>

<?php endif; ?>


<?php if (!empty($_SESSION['error'])): ?>

    <div class="alert alert-danger alert-dismissible fade show shadow-sm mb-4">

        <i class="fas fa-circle-exclamation me-2"></i>

        <?= htmlspecialchars($_SESSION['error']) ?>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

    <?php unset($_SESSION['error']); ?>

<?php endif; ?>

    <div class="deposit-page-header mb-4">

        <div>

            <div class="d-flex align-items-center gap-3">

                <div class="deposit-title-icon">

                    <i class="fas fa-receipt"></i>

                </div>

                <div>

                    <h2 class="fw-bold mb-1">

                        Deposit Details

                    </h2>

                    <p class="text-muted mb-0">

                        View complete deposit transaction information.

                    </p>

                </div>

            </div>

        </div>


               <div class="d-flex gap-2">

            <a
                href="<?= base_url(
                    'deposits/edit/'
                    . $deposit['id']
                ) ?>"
                class="btn btn-primary">

                <i class="fas fa-pen me-2"></i>

                Edit Deposit

            </a>


            <form
    action="<?= base_url(
        'deposits/delete/'
        . $deposit['id']
    ) ?>"
    method="POST"
    class="d-inline"
    id="deleteDepositForm">

    <button
        type="button"
        class="btn btn-danger"
        id="deleteDepositBtn">

        <i class="fas fa-trash me-2"></i>

        Delete Deposit

    </button>

</form>

            <a
                href="<?= base_url('deposits') ?>"
                class="btn btn-outline-secondary">

                <i class="fas fa-arrow-left me-2"></i>

                Back

            </a>

        </div>

    </div> <!-- deposit-page-header -->



    <div class="row g-4">

        <!-- Main Information -->

        <div class="col-lg-8">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white p-4">

                    <h5 class="fw-bold mb-0">

                        Transaction Information

                    </h5>

                </div>


                <div class="card-body p-4">

                    <div class="row g-4">

                        <div class="col-md-6">

                            <small class="text-muted d-block">

                                Customer

                            </small>

                            <strong>

                                <?= htmlspecialchars(
                                    $deposit['fullname']
                                ) ?>

                            </strong>

                            <small class="d-block text-muted">

                                <?= htmlspecialchars(
                                    $deposit['customer_code']
                                ) ?>

                            </small>

                        </div>


                        <div class="detail-item">

    <span class="detail-label">
        Account Name
    </span>

    <strong>
        <?= htmlspecialchars(
            $deposit['account_name']
            ?? '—'
        ) ?>
    </strong>

</div>

<div class="detail-item">

    <span class="detail-label">
        Account Number
    </span>

    <strong class="account-number">

        <?= htmlspecialchars(
            $deposit['account_number']
            ?? '—'
        ) ?>

    </strong>

</div>



                        <div class="detail-item">

    <span class="detail-label">
        Bank / Microfinance
    </span>

    <strong>

        <?= htmlspecialchars(
            $deposit['bank_name']
            ?? '—'
        ) ?>

    </strong>

</div>


                        <div class="col-md-6">

                            <small class="text-muted d-block">

                                Transaction Date

                            </small>

                            <strong>

                                <?= date(
                                    'd M Y',
                                    strtotime(
                                        $deposit[
                                            'transaction_date'
                                        ]
                                    )
                                ) ?>

                            </strong>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted d-block">

                                Amount

                            </small>

                            <h4 class="text-success fw-bold mb-0">

                                ₦<?= number_format(
                                    (float) $deposit['amount'],
                                    2
                                ) ?>

                            </h4>

                        </div>


                       <div class="detail-item">

    <span class="detail-label">
        Charges
    </span>

    <strong class="text-danger">

        ₦<?= number_format(
            (float) (
                $deposit['charges']
                ?? 0
            ),
            2
        ) ?>

    </strong>

</div>


                        <div class="col-12">

                            <hr>

                            <small class="text-muted d-block mb-2">

                                Description

                            </small>

                            <p class="mb-0">

                                <?= nl2br(
                                    htmlspecialchars(
                                        $deposit[
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

        <div class="col-lg-4">

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white p-4">

                    <h5 class="fw-bold mb-0">

                        Deposit Summary

                    </h5>

                </div>

                <div class="card-body p-4">

                    <div class="mb-3">

                        <small class="text-muted d-block">

                            Deposit ID

                        </small>

                        <strong>

                            #<?= $deposit['id'] ?>

                        </strong>

                    </div>


                    <div class="mb-3">

                        <small class="text-muted d-block">

                            Created At

                        </small>

                        <strong>

                            <?= date(
                                'd M Y, h:i A',
                                strtotime(
                                    $deposit['created_at']
                                )
                            ) ?>

                        </strong>

                    </div>


                    <div class="alert alert-success">

                        <i class="fas fa-circle-check me-2"></i>

                        Deposit successfully recorded.

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

<script>

document
    .getElementById('deleteDepositBtn')
    .addEventListener('click', function () {

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
                    .getElementById('deleteDepositForm')
                    .submit();

            }

        });

    });

</script>