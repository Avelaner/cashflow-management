<?php

declare(strict_types=1);

use App\Core\App;

define('BASE_PATH', dirname(__DIR__));

require BASE_PATH . '/vendor/autoload.php';

App::run();