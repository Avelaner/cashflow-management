<?php

use App\Controllers\AuthController;
use App\Controllers\HomeController;
use App\Controllers\DashboardController;
use App\Controllers\CustomerController;
use App\Controllers\DepositController;
use App\Controllers\WithdrawalController;
use App\Controllers\ExpenseController;
use App\Controllers\ItemController; // <--- ADD THIS LINE
use App\Controllers\ReportController;
use App\Controllers\ActivityController;


/*
|--------------------------------------------------------------------------
| General Routes
|--------------------------------------------------------------------------
*/

$router->get(
    '/dashboard',
    [DashboardController::class, 'index']
);

$router->get(
    '/',
    [HomeController::class, 'index']
);

$router->get(
    '/login',
    [AuthController::class, 'login']
);

$router->post(
    '/login',
    [AuthController::class, 'authenticate']
);

$router->get(
    '/logout',
    [AuthController::class, 'logout']
);


/*
|--------------------------------------------------------------------------
| Customer Routes
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

/*
|--------------------------------------------------------------------------
| Deposits / Transfers
|--------------------------------------------------------------------------
*/

$router->get(
    '/deposits',
    [DepositController::class, 'index']
);

$router->get(
    '/deposits/create',
    [DepositController::class, 'create']
);

$router->post(
    '/deposits/store',
    [DepositController::class, 'store']
);

$router->get(
    '/deposits/show/{id}',
    [DepositController::class, 'show']
);

$router->get(
    '/deposits/edit/{id}',
    [DepositController::class, 'edit']
);

$router->post(
    '/deposits/update/{id}',
    [DepositController::class, 'update']
);

$router->post(
    '/deposits/delete/{id}',
    [DepositController::class, 'delete']
);

/*
|--------------------------------------------------------------------------
| Deposits
|--------------------------------------------------------------------------
*/

$router->get(
    '/deposits/show/{id}',
    [DepositController::class, 'show']
);

$router->get(
    '/deposits/edit/{id}',
    [DepositController::class, 'edit']
);

$router->post(
    '/deposits/update/{id}',
    [DepositController::class, 'update']
);

$router->post(
    '/deposits/delete/{id}',
    [DepositController::class, 'delete']
);

/*
|--------------------------------------------------------------------------
| Withdrawals
|--------------------------------------------------------------------------
*/

$router->get(
    '/withdrawals',
    [WithdrawalController::class, 'index']
);

$router->get(
    '/withdrawals/create',
    [WithdrawalController::class, 'create']
);

$router->post(
    '/withdrawals/store',
    [WithdrawalController::class, 'store']
);

$router->get(
    '/withdrawals/show/{id}',
    [WithdrawalController::class, 'show']
);

$router->get(
    '/withdrawals/edit/{id}',
    [WithdrawalController::class, 'edit']
);

$router->post(
    '/withdrawals/update/{id}',
    [WithdrawalController::class, 'update']
);

$router->post(
    '/withdrawals/delete/{id}',
    [WithdrawalController::class, 'delete']
);


$router->get('/api/cashflow-data', [DashboardController::class, 'cashflowData']);


$router->get(
    '/expenses',
    [ExpenseController::class, 'index']
);

$router->get(
    '/expenses/create',
    [ExpenseController::class, 'create']
);

$router->post(
    '/expenses/store',
    [ExpenseController::class, 'store']
);

$router->get(
    '/expenses/show/{id}',
    [ExpenseController::class, 'show']
);

$router->get(
    '/expenses/edit/{id}',
    [ExpenseController::class, 'edit']
);

$router->post(
    '/expenses/update/{id}',
    [ExpenseController::class, 'update']
);

$router->post(
    '/expenses/delete/{id}',
    [ExpenseController::class, 'delete']
);

$router->get('/items', [ItemController::class, 'index']);
$router->post('/items/store', [ItemController::class, 'store']);
$router->post('/items/update/{id}', [ItemController::class, 'update']);
$router->post('/items/sell/{id}', [ItemController::class, 'sell']);
$router->post('/items/delete/{id}', [ItemController::class, 'destroy']);

// routes/web.php or index.php



$router->get('reports', [ReportController::class, 'index']);

// User Management Routes
$router->get('users', [App\Controllers\UserController::class, 'index']);
$router->post('users/store', [App\Controllers\UserController::class, 'store']);
$router->post('users/update', [App\Controllers\UserController::class, 'update']);
$router->post('users/toggle-status', [App\Controllers\UserController::class, 'toggleStatus']);
$router->post('users/delete', [App\Controllers\UserController::class, 'delete']);

// --- ACTIVITIES / AUDIT LOG ROUTES ---
$router->get('/activities', [ActivityController::class, 'index']);
$router->post('/activities/clear', [ActivityController::class, 'clear']);