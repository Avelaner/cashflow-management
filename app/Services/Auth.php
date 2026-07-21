<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\User;

class Auth
{
    public static function attempt(
        string $email,
        string $password
    ): bool {

        $userModel = new User();

        $user = $userModel->findByEmail(trim(strtolower($email)));

        if (!$user) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Check Account Status
        |--------------------------------------------------------------------------
        */

        if (strtolower($user['status']) !== 'active') {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Verify Password
        |--------------------------------------------------------------------------
        */

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Start Session
        |--------------------------------------------------------------------------
        */

        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        session_regenerate_id(true);

        /*
        |--------------------------------------------------------------------------
        | Store Logged-in User
        |--------------------------------------------------------------------------
        */

        $_SESSION['user'] = [

            'id' => (int) $user['id'],

            'fullname' => $user['fullname'],

            'email' => $user['email'],

            'phone' => $user['phone'],

            'role' => $user['role'],

            'status' => $user['status'],

            'picture' => $user['picture'],

            'last_login' => $user['last_login']

        ];

        /*
        |--------------------------------------------------------------------------
        | Update Login Time
        |--------------------------------------------------------------------------
        */

        $userModel->updateLastLogin((int) $user['id']);

        return true;
    }

    /**
     * Logout
     */
    public static function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        $_SESSION = [];

        if (ini_get('session.use_cookies')) {

            $params = session_get_cookie_params();

            setcookie(

                session_name(),

                '',

                time() - 42000,

                $params['path'],

                $params['domain'],

                $params['secure'],

                $params['httponly']

            );

        }

        session_destroy();
    }

    /**
     * Check Login
     */
    public static function check(): bool
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }

        return isset($_SESSION['user']);
    }

    /**
     * Current User
     */
    public static function user(): ?array
    {
        return self::check()
            ? $_SESSION['user']
            : null;
    }

    /**
     * Current User ID
     */
    public static function id(): ?int
    {
        return self::check()
            ? (int) $_SESSION['user']['id']
            : null;
    }

    /**
     * Current Role
     */
    public static function role(): ?string
    {
        return self::check()
            ? $_SESSION['user']['role']
            : null;
    }

    /**
     * Is Super Admin
     */
    public static function isSuperAdmin(): bool
    {
        return self::role() === 'super_admin';
    }

    /**
     * Has Role
     */
    public static function hasRole(string $role): bool
    {
        return self::role() === strtolower($role);
    }
}