<?php

declare(strict_types=1);

if (!function_exists('base_url')) {
    /**
     * Get the base URL of the application with an optional path attached.
     */
    function base_url(string $path = ''): string
    {
        $base = rtrim($_ENV['APP_URL'] ?? '', '/');
        $path = ltrim($path, '/');

        return $path ? "{$base}/{$path}" : $base;
    }
}

if (!function_exists('asset')) {
    /**
     * Get the full URL to an asset.
     */
    function asset(string $path): string
    {
        return base_url('assets/' . ltrim($path, '/'));
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect to a given application path.
     */
    function redirect(string $path): void
    {
        header('Location: ' . base_url($path));
        exit;
    }
}