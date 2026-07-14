<?php

declare(strict_types=1);

namespace App\Core;

class View
{
    public static function render(string $view, array $data = [], string $layout = null): void
    {
        extract($data);

        $viewPath = BASE_PATH . "/app/Views/{$view}.php";

        if (!file_exists($viewPath)) {
            die("View '{$view}' not found.");
        }

        ob_start();

        require $viewPath;

        $content = ob_get_clean();

        if ($layout !== null) {

            $layoutPath = BASE_PATH . "/app/Views/layouts/{$layout}.php";

            if (!file_exists($layoutPath)) {
                die("Layout '{$layout}' not found.");
            }

            require $layoutPath;

            return;
        }

        echo $content;
    }
}