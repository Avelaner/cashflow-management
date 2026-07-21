<style>
    :root {
        --primary-color: #2563eb;
        --success-color: #16a34a;
        --warning-color: #d97706;
        --danger-color: #dc2626;
        --bg-card: #ffffff;
        --text-dark: #1e293b;
        --text-muted: #64748b;
        --border-color: #e2e8f0;
    }

    .user-container {
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Helvetica, Arial, sans-serif;
        color: var(--text-dark);
        padding: 24px;
        max-width: 1200px;
        margin: 0 auto;
    }

    /* Page Header */
    .user-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        margin-bottom: 24px;
        gap: 16px;
    }
    .user-header h2 { margin: 0 0 4px 0; font-size: 1.5rem; font-weight: 700; }
    .user-header p { margin: 0; color: var(--text-muted); font-size: 0.875rem; }

    .header-actions { display: flex; gap: 8px; flex-wrap: wrap; }
    .btn-action {
        display: inline-flex;
        align-items: center;
        padding: 8px 14px;
        border-radius: 6px;
        font-size: 0.875rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        border: 1px solid transparent;
        transition: background-color 0.2s ease;
    }
    .btn-primary { background-color: var(--primary-color); color: white; }
    .btn-primary:hover { background-color: #1d4ed8; }
    .btn-dashboard { background-color: #f1f5f9; color: var(--text-dark); border-color: var(--border-color); }
    .btn-dashboard:hover { background-color: #e2e8f0; }
    .btn-logout { background-color: #fee2e2; color: var(--danger-color); border-color: #fca5a5; }
    .btn-logout:hover { background-color: #fecaca; }

    /* Flash Messages */
    .alert {
        padding: 12px 16px;
        border-radius: 6px;
        margin-bottom: 20px;
        font-size: 0.875rem;
        font-weight: 500;
    }
    .alert-success { background-color: #dcfce7; color: #15803d; border: 1px solid #bbf7d0; }
    .alert-danger { background-color: #fee2e2; color: #b91c1c; border: 1px solid #fecaca; }

    /* KPI Summary Cards Grid */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
        gap: 16px;
        margin-bottom: 24px;
    }
    .kpi-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-left: 4px solid var(--primary-color);
        border-radius: 8px;
        padding: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .kpi-card.success { border-left-color: var(--success-color); }
    .kpi-card.danger { border-left-color: var(--danger-color); }

    .kpi-title {
        font-size: 0.75rem;
        font-weight: 700;
        text-transform: uppercase;
        color: var(--text-muted);
    }
    .kpi-value {
        font-size: 1.5rem;
        font-weight: 700;
        margin: 6px 0;
    }
    .kpi-subtext {
        font-size: 0.75rem;
        color: var(--text-muted);
    }

    /* Filter Form */
    .filter-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        padding: 16px;
        margin-bottom: 24px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .filter-form { display: flex; gap: 12px; align-items: center; }
    .form-control {
        padding: 8px 12px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        font-size: 0.875rem;
        width: 100%;
    }

    /* Table Component */
    .table-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 8px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        margin-bottom: 32px;
    }
    .user-table { width: 100%; border-collapse: collapse; text-align: left; font-size: 0.875rem; }
    .user-table th { background-color: #f1f5f9; padding: 12px 16px; font-weight: 600; color: var(--text-muted); border-bottom: 1px solid var(--border-color); }
    .user-table td { padding: 12px 16px; border-bottom: 1px solid var(--border-color); }
    .user-table tr:hover { background-color: #f8fafc; }

    .badge { display: inline-block; padding: 4px 8px; border-radius: 4px; font-size: 0.75rem; font-weight: 600; }
    .badge-active { background-color: #dcfce7; color: #15803d; }
    .badge-blocked { background-color: #fee2e2; color: #b91c1c; }

    /* Action Buttons */
    .btn-sm { padding: 4px 8px; font-size: 0.75rem; border-radius: 4px; border: 1px solid var(--border-color); cursor: pointer; background: white; }
    .btn-edit { color: var(--primary-color); border-color: #bfdbfe; }
    .btn-block { color: var(--warning-color); border-color: #fde68a; }
    .btn-activate { color: var(--success-color); border-color: #bbf7d0; }
    .btn-delete { color: var(--danger-color); border-color: #fecaca; }

    /* Modal Component */
    .modal { display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.5); align-items: center; justify-content: center; z-index: 1000; }
    .modal-content { background: white; border-radius: 8px; width: 100%; max-width: 480px; padding: 24px; box-shadow: 0 10px 25px rgba(0,0,0,0.1); }
    .modal-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
    .modal-header h3 { margin: 0; font-size: 1.125rem; }
    .modal-close { background: none; border: none; font-size: 1.25rem; cursor: pointer; color: var(--text-muted); }
    .form-group-modal { margin-bottom: 14px; }
    .form-group-modal label { display: block; font-size: 0.75rem; font-weight: 700; text-transform: uppercase; margin-bottom: 4px; color: var(--text-muted); }

    /* Footer Branding */
    .user-footer {
        margin-top: 40px;
        padding-top: 16px;
        border-top: 1px solid var(--border-color);
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        font-size: 0.8125rem;
        color: var(--text-muted);
        gap: 8px;
    }
    .user-footer strong { color: var(--text-dark); }
</style>

<?php
// Calculate User KPI Counts
$totalUsers  = count($users);
$activeUsers = count(array_filter($users, fn($u) => strtolower($u['status'] ?? '') === 'active'));
$blockedUsers = count(array_filter($users, fn($u) => strtolower($u['status'] ?? '') === 'blocked'));
?>

<div class="user-container">

    <!-- PAGE HEADER -->
    <div class="user-header">
        <div>
            <h2>User Management</h2>
            <p>Manage system access, roles, active states, and user accounts.</p>
        </div>
        <div class="header-actions">
            <?php if (App\Services\PermissionService::can('users.create')): ?>
                <button onclick="openCreateModal()" class="btn-action btn-primary">+ Add New User</button>
            <?php endif; ?>
            <a href="<?= base_url('dashboard') ?>" class="btn-action btn-dashboard">Dashboard</a>
            <a href="<?= base_url('logout') ?>" class="btn-action btn-logout">Logout</a>
        </div>
    </div>

    <!-- FLASH MESSAGES -->
    <?php if (!empty($flashSuccess)): ?>
        <div class="alert alert-success"><?= htmlspecialchars($flashSuccess) ?></div>
    <?php endif; ?>
    <?php if (!empty($flashError)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($flashError) ?></div>
    <?php endif; ?>

    <!-- USER SUMMARY KPI CARDS -->
    <div class="kpi-grid">
        <div class="kpi-card">
            <div class="kpi-title">Total Users</div>
            <div class="kpi-value" style="color: var(--primary-color);"><?= number_format($totalUsers) ?></div>
            <div class="kpi-subtext">Registered user accounts</div>
        </div>

        <div class="kpi-card success">
            <div class="kpi-title">Active Users</div>
            <div class="kpi-value" style="color: var(--success-color);"><?= number_format($activeUsers) ?></div>
            <div class="kpi-subtext">Accounts with active access</div>
        </div>

        <div class="kpi-card danger">
            <div class="kpi-title">Blocked Users</div>
            <div class="kpi-value" style="color: var(--danger-color);"><?= number_format($blockedUsers) ?></div>
            <div class="kpi-subtext">Suspended/restricted accounts</div>
        </div>
    </div>

    <!-- FILTER / SEARCH -->
    <div class="filter-card">
        <form method="GET" action="<?= base_url('users') ?>" class="filter-form">
            <input type="text" name="search" class="form-control" placeholder="Search by name, email, or role..." value="<?= htmlspecialchars($search ?? '') ?>">
            <button type="submit" class="btn-action btn-dashboard">Search</button>
            <?php if ($search): ?>
                <a href="<?= base_url('users') ?>" class="btn-action btn-dashboard">Reset</a>
            <?php endif; ?>
        </form>
    </div>

    <!-- USERS TABLE -->
    <div class="table-card">
        <table class="user-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th style="text-align: right;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="7" style="text-align: center; color: var(--text-muted); padding: 24px;">No user accounts found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $idx => $user): ?>
                        <tr>
                            <td><?= $idx + 1 ?></td>
                            <td><strong><?= htmlspecialchars($user['fullname']) ?></strong></td>
                            <td><?= htmlspecialchars($user['email']) ?></td>
                            <td><span class="badge" style="background:#e2e8f0; color:#334155;"><?= strtoupper(htmlspecialchars($user['role'])) ?></span></td>
                            <td>
                                <span class="badge <?= strtolower($user['status']) === 'active' ? 'badge-active' : 'badge-blocked' ?>">
                                    <?= ucfirst(htmlspecialchars($user['status'])) ?>
                                </span>
                            </td>
                            <td><?= date('d M, Y', strtotime($user['created_at'])) ?></td>
                            <td style="text-align: right;">
                                <div style="display: inline-flex; gap: 4px;">
                                    <?php if (App\Services\PermissionService::can('users.edit')): ?>
                                        <button onclick='openEditModal(<?= json_encode($user) ?>)' class="btn-sm btn-edit">Edit</button>
                                        
                                        <!-- BLOCK / ACTIVATE TOGGLE -->
                                        <form method="POST" action="<?= base_url('users/toggle-status') ?>" style="display:inline;">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <input type="hidden" name="status" value="<?= strtolower($user['status']) === 'active' ? 'blocked' : 'active' ?>">
                                            <?php if (strtolower($user['status']) === 'active'): ?>
                                                <button type="submit" class="btn-sm btn-block" onclick="return confirm('Block this user account?')">Block</button>
                                            <?php else: ?>
                                                <button type="submit" class="btn-sm btn-activate" onclick="return confirm('Activate this user account?')">Activate</button>
                                            <?php endif; ?>
                                        </form>
                                    <?php endif; ?>

                                    <?php if (App\Services\PermissionService::can('users.delete')): ?>
                                        <form method="POST" action="<?= base_url('users/delete') ?>" style="display:inline;" onsubmit="return confirm('Permanently delete user account?');">
                                            <input type="hidden" name="id" value="<?= $user['id'] ?>">
                                            <button type="submit" class="btn-sm btn-delete">Delete</button>
                                        </form>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <!-- SYSTEM FOOTER -->
    <footer class="user-footer">
        <div>
            &copy; <?= date('Y') ?> <strong>Cashflow CMS</strong>. Developed by <strong>Engr. Avela Nder Marcel</strong> | <strong>NderTech Universal Services</strong>.
        </div>
        <div>
            User Directory Module
        </div>
    </footer>

</div>

<!-- CREATE USER MODAL -->
<div id="createModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Add New User</h3>
            <button class="modal-close" onclick="closeCreateModal()">&times;</button>
        </div>
        <form method="POST" action="<?= base_url('users/store') ?>">
            <div class="form-group-modal">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group-modal">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="form-group-modal">
                <label>Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="form-group-modal">
                <label>System Role</label>
                <select name="role" class="form-control" required>
                    <option value="cashier">Cashier</option>
                    <option value="manager">Manager</option>
                    <option value="admin">Adminitrator</option>
                    <option value="uper_admin">uper Administrator</option>
                </select>
            </div>
            <div style="text-align: right; margin-top: 20px;">
                <button type="button" class="btn-action btn-dashboard" onclick="closeCreateModal()">Cancel</button>
                <button type="submit" class="btn-action btn-primary">Save User</button>
            </div>
        </form>
    </div>
</div>

<!-- EDIT USER MODAL -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Edit User Account</h3>
            <button class="modal-close" onclick="closeEditModal()">&times;</button>
        </div>
        <form method="POST" action="<?= base_url('users/update') ?>">
            <input type="hidden" name="id" id="edit_id">
            <div class="form-group-modal">
                <label>Full Name</label>
                <input type="text" name="name" id="edit_name" class="form-control" required>
            </div>
            <div class="form-group-modal">
                <label>Email Address</label>
                <input type="email" name="email" id="edit_email" class="form-control" required>
            </div>
            <div class="form-group-modal">
                <label>New Password (Leave blank to keep unchanged)</label>
                <input type="password" name="password" class="form-control">
            </div>
            <div class="form-group-modal">
                <label>System Role</label>
                <select name="role" id="edit_role" class="form-control" required>
                    <option value="cashier">Cashier</option>
                    <option value="manager">Manager</option>
                    <option value="admin">Adminitrator</option>
                    <option value="uper_admin">uper Administrator</option>
                </select>
            </div>
            <div style="text-align: right; margin-top: 20px;">
                <button type="button" class="btn-action btn-dashboard" onclick="closeEditModal()">Cancel</button>
                <button type="submit" class="btn-action btn-primary">Update User</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openCreateModal() { document.getElementById('createModal').style.display = 'flex'; }
    function closeCreateModal() { document.getElementById('createModal').style.display = 'none'; }
    function openEditModal(user) {
        document.getElementById('edit_id').value = user.id;
        document.getElementById('edit_name').value = user.name;
        document.getElementById('edit_email').value = user.email;
        document.getElementById('edit_role').value = user.role;
        document.getElementById('editModal').style.display = 'flex';
    }
    function closeEditModal() { document.getElementById('editModal').style.display = 'none'; }
</script>