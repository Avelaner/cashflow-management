<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Services\Auth;

class AuthMiddleware
{
    public static function handle(): void
    {
        if (!Auth::check()) {

            header('Location: /cashflow-management/public/login');

            exit;
        }
    }
}