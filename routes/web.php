<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;

$router->get('/', [HomeController::class, 'index']);
$router->get('/login', [AuthController::class, 'login']);