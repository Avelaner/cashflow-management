<?php

declare(strict_types=1);

namespace App\Services;

class PermissionService
{
    /**
     * Loaded role configuration.
     */
    private static ?array $roles = null;

    /**
     * Load roles once.
     */
    private static function roles(): array
    {
        if (self::$roles === null) {
            self::$roles = require BASE_PATH . '/config/roles.php';
        }

        return self::$roles;
    }

    /**
     * Check if the current user has a permission.
     */
    public static function can(string $permission): bool
    {
        if (!Auth::check()) {
            return false;
        }

        $role = strtolower(Auth::role() ?? '');

        $roles = self::roles();

        if (!isset($roles[$role])) {
            return false;
        }

        return in_array($permission, $roles[$role], true);
    }

    /**
     * Opposite of can()
     */
    public static function cannot(string $permission): bool
    {
        return !self::can($permission);
    }

    /**
     * User has at least one permission.
     */
    public static function canAny(array $permissions): bool
    {
        foreach ($permissions as $permission) {

            if (self::can($permission)) {
                return true;
            }

        }

        return false;
    }

    /**
     * User has every permission.
     */
    public static function canAll(array $permissions): bool
    {
        foreach ($permissions as $permission) {

            if (!self::can($permission)) {
                return false;
            }

        }

        return true;
    }

    /**
     * Current user's role.
     */
    public static function role(): ?string
    {
        return Auth::role();
    }
}