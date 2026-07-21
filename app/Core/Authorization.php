<?php

declare(strict_types=1);

namespace App\Core;

use App\Services\Auth;
use App\Services\PermissionService;

class Authorization
{
    /**
     * Require user to be logged in.
     */
    public static function authenticate(): void
    {
        if (!Auth::check()) {

            header('Location: ' . base_url('login'));

            exit;

        }
    }

    /**
     * Require a permission.
     */
 public static function authorize(string $permission): void
{
    self::authenticate();

    if (!PermissionService::can($permission)) {

        http_response_code(403);

        require BASE_PATH . '/app/Views/errors/403.php';

        exit;
    }
}
}