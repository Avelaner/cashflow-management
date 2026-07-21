<div class="dashboard-card">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <h5 class="fw-bold mb-0">

            Today's Summary

        </h5>

        <span class="badge bg-primary">

            Today

        </span>

    </div>

    <table class="table table-borderless align-middle mb-0">

        <tbody>

            <tr>

                <td>

                    <i class="fas fa-users text-primary me-2"></i>

                    Customers

                </td>

                <td class="text-end fw-bold">

                    <?= number_format($summary['customers']) ?>

                </td>

            </tr>

            <tr>

                <td>

                    <i class="fas fa-money-bill-transfer text-success me-2"></i>

                    Deposits

                </td>

                <td class="text-end fw-bold">

                    <?= number_format($summary['deposits']) ?>

                </td>

            </tr>

            <tr>

                <td>

                    <i class="fas fa-money-bill-wave text-warning me-2"></i>

                    Withdrawals

                </td>

                <td class="text-end fw-bold">

                    <?= number_format($summary['withdrawals']) ?>

                </td>

            </tr>

            <tr>

                <td>

                    <i class="fas fa-wallet text-danger me-2"></i>

                    Expenses

                </td>

                <td class="text-end fw-bold">

                    <?= number_format($summary['expenses']) ?>

                </td>

            </tr>

        </tbody>

    </table>

</div>