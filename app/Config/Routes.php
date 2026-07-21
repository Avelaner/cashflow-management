<?php

declare(strict_types=1);

use App\Core\Router;
use App\Controllers\DashboardController;
use App\Controllers\CustomerController;


/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

$router->get(

    '/dashboard',

    [DashboardController::class, 'index']

);


/*
|--------------------------------------------------------------------------
| Customers
|--------------------------------------------------------------------------
*/

$router->get(

    '/customers',

    [CustomerController::class, 'index']

);


$router->get(

    '/customers/create',

    [CustomerController::class, 'create']

);


$router->post(

    '/customers/store',

    [CustomerController::class, 'store']

);


$router->get(

    '/customers/show/{id}',

    [CustomerController::class, 'show']

);


$router->get(

    '/customers/edit/{id}',

    [CustomerController::class, 'edit']

);


$router->post(

    '/customers/update/{id}',

    [CustomerController::class, 'update']

);


$router->post(

    '/customers/delete/{id}',

    [CustomerController::class, 'delete']

);