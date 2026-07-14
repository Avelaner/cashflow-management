<?php

declare(strict_types=1);

namespace App\Core;

class View
{
    public static function render(string $view, array $data = []): void
    {
        extract($data);

        $path = BASE_PATH . "/app/Views/{$view}.php";

        if (! file_exists($path)) {
            die("View {$view} not found.");
        }

        require $path;
    }
}