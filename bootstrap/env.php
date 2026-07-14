<?php

declare(strict_types=1);

use Dotenv\Dotenv;

require_once BASE_PATH . '/vendor/autoload.php';

$dotenv = Dotenv::createImmutable(BASE_PATH);
$dotenv->safeLoad();