<?php

use App\Services\PermissionService;

$flash = $_SESSION['flash'] ?? null;

unset($_SESSION['flash']);
?>

<div class="container-fluid customer-page">
    <?php if ($flash): ?>

    <div
        class="alert alert-<?= htmlspecialchars($flash['type']) ?> alert-dismissible fade show shadow-sm"
        role="alert">

        <i class="fas
            <?= $flash['type'] === 'success'
                ? 'fa-circle-check'
                : 'fa-circle-exclamation'
            ?>
            me-2">
        </i>

        <?= htmlspecialchars($flash['message']) ?>

        <button
            type="button"
            class="btn-close"
            data-bs-dismiss="alert">
        </button>

    </div>

<?php endif; ?>

    <!-- Page Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="fw-bold mb-1">
                Customers
            </h2>

            <p class="text-muted mb-0">
                Manage all registered customers.
            </p>

        </div>

        <?php if (PermissionService::can('customers.create')): ?>

            <a href="<?= base_url('customers/create') ?>"
               class="btn btn-primary">

                <i class="fas fa-user-plus me-2"></i>

                Add Customer

            </a>

        <?php endif; ?>

    </div>

    <!-- Statistics -->
    <?php require __DIR__ . '/widgets/stats.php'; ?>

    <!-- Filters -->
    <?php require __DIR__ . '/widgets/filters.php'; ?>

    <!-- Customer Table -->
    <div class="card shadow-sm border-0 customer-table-card">

        <div class="card-header bg-white d-flex justify-content-between align-items-center">

            <h5 class="fw-bold mb-0">

                Customer List

            </h5>

            <span class="badge bg-primary">

                <?= count($customers) ?> Customer<?= count($customers) !== 1 ? 's' : '' ?>

            </span>

        </div>

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0 customer-table">

                <thead class="table-light">

                    <tr>

                        <th>#</th>

                        <th>Photo</th>

                        <th>Customer Code</th>

                        <th>Full Name</th>

                        <th>Phone</th>

                        <th>Email</th>

                        <th>Status</th>

                        <th class="text-center">Actions</th>

                    </tr>

                </thead>

                <tbody>

                <?php if (!empty($customers)): ?>

                    <?php foreach ($customers as $index => $customer): ?>

                        <tr>

                            <td><?= $index + 1 ?></td>

                            <td>

                                <img
                                    src="<?= asset('uploads/customers/' . ($customer['picture'] ?: 'default.png')) ?>"
                                    alt="<?= htmlspecialchars($customer['fullname']) ?>"
                                    class="customer-avatar rounded-circle">

                            </td>

                            <td>

                                <strong>

                                    <?= htmlspecialchars($customer['customer_code']) ?>

                                </strong>

                            </td>

                            <td>

                                <?= htmlspecialchars($customer['fullname']) ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($customer['phone']) ?>

                            </td>

                            <td>

                                <?= htmlspecialchars($customer['email']) ?>

                            </td>

                            <td>

                                <?php if ($customer['status'] === 'Active'): ?>

                                    <span class="badge bg-success">

                                        Active

                                    </span>

                                <?php else: ?>

                                    <span class="badge bg-danger">

                                        Inactive

                                    </span>

                                <?php endif; ?>

                            </td>

                            <td class="text-center">

                                <div class="btn-group">

                                    <?php if (PermissionService::can('customers.view')): ?>

                                        <a
                                            href="<?= base_url('customers/show/' . $customer['id']) ?>"
                                            class="btn btn-sm btn-outline-primary">

                                            <i class="fas fa-eye"></i>

                                        </a>

                                    <?php endif; ?>

                                    <?php if (PermissionService::can('customers.edit')): ?>

                                        <a
                                            href="<?= base_url('customers/edit/' . $customer['id']) ?>"
                                            class="btn btn-sm btn-outline-warning">

                                            <i class="fas fa-pen"></i>

                                        </a>

                                    <?php endif; ?>

                                    <?php if (PermissionService::can('customers.delete')): ?>

                                      <button
                                        type="button"
                                        class="btn btn-sm btn-outline-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteCustomerModal<?= $customer['id'] ?>">

                                        <i class="fas fa-trash"></i>

                                    </button>

                                    <?php endif; ?>

                                </div>

                            </td>

                        </tr>
                        <!-- Delete Confirmation Modal -->

<div
    class="modal fade"
    id="deleteCustomerModal<?= $customer['id'] ?>"
    tabindex="-1"
    aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered">

        <div class="modal-content border-0 shadow">

            <div class="modal-header">

                <h5 class="modal-title fw-bold">

                    <i class="fas fa-triangle-exclamation text-danger me-2"></i>

                    Delete Customer

                </h5>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal">
                </button>

            </div>

            <div class="modal-body text-center py-4">

                <i
                    class="fas fa-user-slash text-danger"
                    style="font-size:50px;">
                </i>

                <h5 class="mt-3">

                    Are you sure?

                </h5>

                <p class="text-muted mb-0">

                    You are about to delete

                    <strong>
                        <?= htmlspecialchars($customer['fullname']) ?>
                    </strong>.

                    This action cannot be undone.

                </p>

            </div>

            <div class="modal-footer justify-content-center">

                <button
                    type="button"
                    class="btn btn-outline-secondary"
                    data-bs-dismiss="modal">

                    Cancel

                </button>

                <form
                    action="<?= base_url('customers/delete/' . $customer['id']) ?>"
                    method="POST">

                    <button
                        type="submit"
                        class="btn btn-danger">

                        <i class="fas fa-trash me-2"></i>

                        Yes, Delete Customer

                    </button>

                </form>

            </div>

        </div>

    </div>

</div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <tr>

                        <td colspan="8" class="text-center py-5">

                            <i class="fas fa-users fa-3x text-muted mb-3 d-block"></i>

                            <h5>No customers found</h5>

                            <p class="text-muted mb-0">

                                Click <strong>Add Customer</strong> to register your first customer.

                            </p>

                        </td>

                    </tr>

                <?php endif; ?>

                </tbody>

            </table>

        </div>

    </div>

</div>