<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\User;
use App\Services\PermissionService;

class UserController
{
    public function index(): void
    {
        if (!PermissionService::can('users.view')) {
            http_response_code(403);
            require_once __DIR__ . '/../Views/errors/403.php';
            return;
        }

        $search = $_GET['search'] ?? null;
        $users  = User::getAll($search);

        $flashSuccess = $_SESSION['flash_success'] ?? null;
        $flashError   = $_SESSION['flash_error'] ?? null;
        unset($_SESSION['flash_success'], $_SESSION['flash_error']);

        require_once __DIR__ . '/../Views/users/index.php';
    }

    public function store(): void
    {
        if (!PermissionService::can('users.create')) {
            http_response_code(403);
            return;
        }

        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $role     = $_POST['role'] ?? 'staff';

        if (empty($name) || empty($email) || empty($password)) {
            $_SESSION['flash_error'] = 'All required fields must be filled out.';
            header('Location: ' . base_url('users'));
            exit;
        }

        if (User::emailExists($email)) {
            $_SESSION['flash_error'] = 'Email address is already in use.';
            header('Location: ' . base_url('users'));
            exit;
        }

        if (User::create(['name' => $name, 'email' => $email, 'password' => $password, 'role' => $role, 'status' => 'active'])) {
            $_SESSION['flash_success'] = 'User created successfully.';
        } else {
            $_SESSION['flash_error'] = 'Failed to create user.';
        }

        header('Location: ' . base_url('users'));
        exit;
    }

    public function update(): void
    {
        if (!PermissionService::can('users.edit')) {
            http_response_code(403);
            return;
        }

        $id       = (int)($_POST['id'] ?? 0);
        $name     = trim($_POST['name'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? null;
        $role     = $_POST['role'] ?? 'staff';

        if ($id <= 0 || empty($name) || empty($email)) {
            $_SESSION['flash_error'] = 'Invalid request parameters.';
            header('Location: ' . base_url('users'));
            exit;
        }

        if (User::emailExists($email, $id)) {
            $_SESSION['flash_error'] = 'Email address is already used by another account.';
            header('Location: ' . base_url('users'));
            exit;
        }

        $updateData = ['name' => $name, 'email' => $email, 'role' => $role];
        if (!empty($password)) {
            $updateData['password'] = $password;
        }

        if (User::update($id, $updateData)) {
            $_SESSION['flash_success'] = 'User details updated successfully.';
        } else {
            $_SESSION['flash_error'] = 'Failed to update user.';
        }

        header('Location: ' . base_url('users'));
        exit;
    }

    public function toggleStatus(): void
    {
        if (!PermissionService::can('users.edit')) {
            http_response_code(403);
            return;
        }

        $id     = (int)($_POST['id'] ?? 0);
        $status = $_POST['status'] === 'blocked' ? 'blocked' : 'active';

        // Prevent self-blocking
        if (isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] === $id) {
            $_SESSION['flash_error'] = 'You cannot block your own active session.';
            header('Location: ' . base_url('users'));
            exit;
        }

        if (User::updateStatus($id, $status)) {
            $_SESSION['flash_success'] = "User status updated to {$status}.";
        } else {
            $_SESSION['flash_error'] = 'Failed to change user status.';
        }

        header('Location: ' . base_url('users'));
        exit;
    }

    public function delete(): void
    {
        if (!PermissionService::can('users.delete')) {
            http_response_code(403);
            return;
        }

        $id = (int)($_POST['id'] ?? 0);

        if (isset($_SESSION['user_id']) && (int)$_SESSION['user_id'] === $id) {
            $_SESSION['flash_error'] = 'You cannot delete your own account while logged in.';
            header('Location: ' . base_url('users'));
            exit;
        }

        if (User::delete($id)) {
            $_SESSION['flash_success'] = 'User deleted successfully.';
        } else {
            $_SESSION['flash_error'] = 'Failed to delete user.';
        }

        header('Location: ' . base_url('users'));
        exit;
    }
}