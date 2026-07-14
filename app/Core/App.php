<?php

declare(strict_types=1);

namespace App\Core;

class App
{
    public static function run(): void
    {
        $router = new Router();

        require BASE_PATH . '/routes/web.php';

        $router->dispatch();
    }
}