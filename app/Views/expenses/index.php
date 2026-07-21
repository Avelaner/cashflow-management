<?php

declare(strict_types=1);

use App\Services\PermissionService;

?>

<div class="container-fluid expense-page">

    <!-- Page Header -->
    <div class="expense-page-header mb-4">
        <div>
            <div class="d-flex align-items-center gap-3 mb-2">
                <div class="expense-title-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div>
                    <h2 class="fw-bold mb-0">Expenses</h2>
                    <p class="text-muted mb-0">Manage and track all business expenses.</p>
                </div>
            </div>
        </div>

        <?php if (PermissionService::can('expenses.create')): ?>
            <a href="<?= base_url('expenses/create') ?>" class="btn btn-primary expense-add-btn">
                <i class="fas fa-plus me-2"></i> New Expense
            </a>
        <?php endif; ?>
    </div>

    <!-- Flash Messages -->
    <?php if (!empty($_SESSION['success'])): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-circle-check me-2"></i>
            <?= htmlspecialchars($_SESSION['success']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (!empty($_SESSION['error'])): ?>
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-circle-exclamation me-2"></i>
            <?= htmlspecialchars($_SESSION['error']) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <!-- Auto Close Alerts -->
    <script>
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(alert);
            bsAlert.close();
        });
    }, 5000);
    </script>

    <!-- Statistics Widget -->
    <?php require __DIR__ . '/widgets/stats.php'; ?>

    <!-- Filters Widget -->
    <?php require __DIR__ . '/widgets/filters.php'; ?>

    <!-- Expenses Table -->
    <div class="card expense-table-card">
        <div class="card-header">
            <div>
                <h5 class="fw-bold mb-1">Expense Records</h5>
                <small class="text-muted">
                    Showing <?= count($expenses) ?> expense records
                </small>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table align-middle expense-table mb-0">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Category</th>
                        <th>Description</th>
                        <th>Amount</th>
                        <th>Payment Method</th>
                        <th>Date</th>
                        <th>Recorded By</th>
                        <th class="text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php if (!empty($expenses)): ?>
                    <?php foreach ($expenses as $index => $expense): ?>
                        <tr>
                            <!-- Number -->
                            <td class="text-muted"><?= $index + 1 ?></td>

                            <!-- Category -->
                            <td>
                                <span class="expense-category-badge">
                                    <i class="fas fa-tag me-1"></i>
                                    <?= htmlspecialchars($expense['category']) ?>
                                </span>
                            </td>

                            <!-- Description -->
                            <td>
                                <span class="expense-description">
                                    <?= htmlspecialchars($expense['description'] ?? '—') ?>
                                </span>
                            </td>

                            <!-- Amount -->
                            <td>
                                <strong class="amount-negative">
                                    ₦<?= number_format((float) $expense['amount'], 2) ?>
                                </strong>
                            </td>

                            <!-- Payment Method -->
                            <td>
                                <span class="payment-method-badge">
                                    <i class="fas fa-credit-card me-1"></i>
                                    <?= htmlspecialchars($expense['payment_method'] ?? '—') ?>
                                </span>
                            </td>

                            <!-- Date -->
                            <td>
                                <span class="date-cell">
                                    <i class="far fa-calendar me-1"></i>
                                    <?= date('d M Y', strtotime($expense['transaction_date'])) ?>
                                </span>
                            </td>

                            <!-- Recorded By -->
                            <td>
                                <span class="recorded-by">
                                    <i class="fas fa-user me-1"></i>
                                    <?= htmlspecialchars($expense['created_by_name'] ?? 'System') ?>
                                </span>
                            </td>

                            <!-- Actions -->
                            <td class="text-center">
                                <div class="expense-actions">
                                    <?php if (PermissionService::can('expenses.view')): ?>
                                        <a href="<?= base_url('expenses/show/' . $expense['id']) ?>" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="View Expense">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (PermissionService::can('expenses.edit')): ?>
                                        <a href="<?= base_url('expenses/edit/' . $expense['id']) ?>" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Edit Expense">
                                            <i class="fas fa-pen"></i>
                                        </a>
                                    <?php endif; ?>

                                    <?php if (PermissionService::can('expenses.delete')): ?>
                                        <form action="<?= base_url('expenses/delete/' . $expense['id']) ?>" 
                                              method="POST" 
                                              class="d-inline" 
                                              id="deleteExpenseForm<?= $expense['id'] ?>">
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-danger" 
                                                    title="Delete Expense" 
                                                    onclick="confirmDeleteExpense(<?= $expense['id'] ?>)">
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
                        <td colspan="8" class="text-center py-5">
                            <div class="empty-expense-state">
                                <i class="fas fa-receipt"></i>
                                <h5>No expenses found</h5>
                                <p class="text-muted">No expense records are available.</p>
                            </div>
                        </td>
                    </tr>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function confirmDeleteExpense(id) {
    Swal.fire({
        title: 'Delete Expense?',
        text: 'This expense record will be permanently deleted.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash me-2"></i> Yes, Delete',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('deleteExpenseForm' + id).submit();
        }
    });
}
</script>