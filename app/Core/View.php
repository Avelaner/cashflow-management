<?php

declare(strict_types=1);

namespace App\Core;

class View
{
    public static function render(
        string $view,
        array $data = [],
        ?string $layout = null
    ): void {

        // Make view variables available
        extract($data);

        // View path
        $viewPath = BASE_PATH . "/app/Views/{$view}.php";

        if (!file_exists($viewPath)) {
            die("View '{$view}' not found.");
        }

        // Capture view output
        ob_start();

        require $viewPath;

        $content = ob_get_clean();

        // Default layout
        if (empty($layout)) {
            $layout = 'master';
        }

        // Layout path
        $layoutPath = BASE_PATH . "/app/Views/layouts/{$layout}.php";

        if (!file_exists($layoutPath)) {
            die("Layout '{$layout}' not found.");
        }

        require $layoutPath;
    }
}