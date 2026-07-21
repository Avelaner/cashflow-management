<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Services\Auth;

class AuthController extends Controller
{
    /**
     * Show login page
     */
    public function login(): void
    {
        if (Auth::check()) {
    header('Location: /cashflow-management/public/dashboard');
    exit;
}
        $this->view(
            'auth/login',
            [
                'title'   => 'Login',
                'pageCss' => 'auth'
            ],
            'guest'
        );
    }

    /**
     * Process login
     */
    public function authenticate(): void
    {
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        if (Auth::attempt($email, $password)) {

            header('Location: /cashflow-management/public/dashboard');
            exit;
        }

        $_SESSION['login_error'] = 'Invalid email or password.';

        header('Location: /cashflow-management/public/login');
        exit;
    }

    /**
     * Logout
     */
    public function logout(): void
    {
        Auth::logout();

        header('Location: /cashflow-management/public/login');
        exit;
    }
}