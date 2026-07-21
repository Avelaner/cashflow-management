<nav class="top-navbar">

    <div class="navbar-left">

        <button
            id="toggleSidebar"
            class="sidebar-toggle"
            type="button"
            aria-label="Toggle sidebar">

            <i class="fas fa-bars"></i>

        </button>

        <div class="page-heading">

            <span class="page-heading-label">
                Cashflow Management
            </span>

            <h5 class="page-title">
                <?= htmlspecialchars($title ?? 'Dashboard') ?>
            </h5>

        </div>

    </div>


    <div class="navbar-right">

        <!-- Notifications -->
        <div class="dropdown">

            <button
                class="notification-btn"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">

                <i class="fas fa-bell"></i>

                <span class="notification-badge">
                    3
                </span>

            </button>


            <div class="dropdown-menu dropdown-menu-end notification-dropdown">

                <div class="notification-header">

                    <div>

                        <strong>
                            Notifications
                        </strong>

                        <small>
                            Recent system activity
                        </small>

                    </div>

                    <span class="badge bg-primary">
                        3 New
                    </span>

                </div>


                <div class="notification-body">

                    <a href="#" class="notification-item">

                        <div class="notification-icon bg-success">

                            <i class="fas fa-money-bill-transfer"></i>

                        </div>

                        <div>

                            <strong>
                                New Deposit
                            </strong>

                            <small>
                                John Doe deposited ₦50,000
                            </small>

                            <time>
                                2 mins ago
                            </time>

                        </div>

                    </a>


                    <a href="#" class="notification-item">

                        <div class="notification-icon bg-primary">

                            <i class="fas fa-user-plus"></i>

                        </div>

                        <div>

                            <strong>
                                New Customer
                            </strong>

                            <small>
                                Sarah James registered
                            </small>

                            <time>
                                15 mins ago
                            </time>

                        </div>

                    </a>


                    <a href="#" class="notification-item">

                        <div class="notification-icon bg-danger">

                            <i class="fas fa-wallet"></i>

                        </div>

                        <div>

                            <strong>
                                Expense Added
                            </strong>

                            <small>
                                Office expense recorded
                            </small>

                            <time>
                                1 hour ago
                            </time>

                        </div>

                    </a>

                </div>


                <div class="notification-footer">

                    <a href="#">
                        View all notifications
                    </a>

                </div>

            </div>

        </div>


        <!-- User Menu -->
        <div class="dropdown">

            <button
                class="user-toggle"
                type="button"
                data-bs-toggle="dropdown"
                aria-expanded="false">

                <img
                    src="<?= asset('images/default.png') ?>"
                    alt="Profile"
                    class="user-avatar">


                <div class="user-info">

                    <strong>

                        <?= htmlspecialchars(
                            \App\Services\Auth::user()['fullname']
                        ) ?>

                    </strong>

                    <small>

                        <?= htmlspecialchars(
                            \App\Services\Auth::user()['role']
                        ) ?>

                    </small>

                </div>


                <i class="fas fa-chevron-down user-arrow"></i>

            </button>


            <ul class="dropdown-menu dropdown-menu-end user-dropdown">

                <li>
    <a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#profileModal">
        <i class="fas fa-user"></i>
        My Profile
    </a>
</li>


                <li>

                    <a class="dropdown-item" href="#">

                        <i class="fas fa-cog"></i>

                        Settings

                    </a>

                </li>


                <li>

                    <hr class="dropdown-divider">

                </li>


                <li>

                    <a
                        class="dropdown-item logout-item"
                        href="<?= base_url('logout') ?>">

                        <i class="fas fa-right-from-bracket"></i>

                        Logout

                    </a>

                </li>

            </ul>

        </div>

    </div>

</nav>
<!-- Profile Modal -->
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow">
            
            <div class="modal-header bg-light">
                <h5 class="modal-title fw-bold" id="profileModalLabel">User Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-4 text-center">
                <!-- User Avatar -->
                <div class="mb-3">
                    <img src="<?= asset('images/default.png') ?>" 
                         alt="Profile" 
                         class="rounded-circle img-thumbnail shadow-sm" 
                         style="width: 110px; height: 110px; object-fit: cover;">
                </div>

                <!-- User Name & Role -->
                <h4 class="fw-bold mb-1">
                    <?= htmlspecialchars(\App\Services\Auth::user()['fullname'] ?? 'User') ?>
                </h4>
                <span class="badge bg-primary text-uppercase px-3 py-2 mb-3">
                    <?= htmlspecialchars(\App\Services\Auth::user()['role'] ?? 'Member') ?>
                </span>

                <!-- User Details Card -->
                <div class="card bg-light border-0 text-start p-3 mt-2">
                    <div class="mb-2">
                        <small class="text-muted d-block fw-semibold">Email Address</small>
                        <span class="text-dark">
                            <?= htmlspecialchars(\App\Services\Auth::user()['email'] ?? 'N/A') ?>
                        </span>
                    </div>

                    <div>
                        <small class="text-muted d-block fw-semibold">Account Status</small>
                        <span class="text-success fw-medium">
                            <i class="fas fa-circle-check me-1"></i> Active
                        </span>
                    </div>
                </div>
            </div>

            <div class="modal-footer border-0 bg-light">
                <button type="button" class="btn btn-secondary px-4" data-bs-dismiss="modal">Close</button>
            </div>

        </div>
    </div>
</div>