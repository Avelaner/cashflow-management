<div class="dashboard-card">

    <div class="d-flex justify-content-between align-items-center mb-3">

        <div>

            <h5 class="fw-bold mb-1">

                Recent Customers

            </h5>

            <small class="text-muted">

                Newly registered customers

            </small>

        </div>

        <a href="<?= base_url('customers') ?>" class="btn btn-sm btn-outline-primary">

            View All

        </a>

    </div>

    <div class="list-group list-group-flush">

        <?php if (!empty($customers)): ?>

            <?php foreach ($customers as $customer): ?>

                <div class="list-group-item px-0">

                    <div class="d-flex align-items-center">

                        <img
                            src="<?= asset('images/default.png') ?>"
                            alt="Customer"
                            class="customer-avatar me-3">

                        <div class="flex-grow-1">

                            <h6 class="mb-1">

                                <?= htmlspecialchars($customer) ?>

                            </h6>

                            <small class="text-muted">

                                Joined Today

                            </small>

                        </div>

                        <span class="badge bg-success">

                            New

                        </span>

                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="text-center py-4 text-muted">

                No recent customers found.

            </div>

        <?php endif; ?>

    </div>

</div>