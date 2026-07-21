<?php

declare(strict_types=1);

use App\Core\Router;

/*
|--------------------------------------------------------------------------
| Base Path & Autoloader
|--------------------------------------------------------------------------
*/

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Environment & Helpers
|--------------------------------------------------------------------------
*/

require BASE_PATH . '/bootstrap/env.php';
require BASE_PATH . '/app/Helpers/helpers.php';

/*
|--------------------------------------------------------------------------
| Session Initialization
|--------------------------------------------------------------------------
*/

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/*
|--------------------------------------------------------------------------
| Router & Route Loading
|--------------------------------------------------------------------------
*/

$router = new Router();

require BASE_PATH . '/app/Config/Routes.php';
require BASE_PATH . '/routes/web.php';

/*
|--------------------------------------------------------------------------
| Dispatch Request
|--------------------------------------------------------------------------
*/

$method = $_SERVER['REQUEST_METHOD'];
$uri    = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

$router->dispatch($uri, $method);