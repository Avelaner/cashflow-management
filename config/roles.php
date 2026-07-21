<?php

declare(strict_types=1);

return [

    'super_admin' => [

        // Dashboard
        'dashboard.view',

        // Customers
        'customers.view',
        'customers.create',
        'customers.edit',
        'customers.delete',

        // Deposits
        'deposits.view',
        'deposits.create',
        'deposits.edit',
        'deposits.delete',

        // Withdrawals
        'withdrawals.view',
        'withdrawals.create',
        'withdrawals.edit',
        'withdrawals.delete',

        // Expenses
        'expenses.view',
        'expenses.create',
        'expenses.edit',
        'expenses.delete',

        // Items
        'items.view',
        'items.create',
        'items.edit',
        'items.delete',

        // Reports
        'reports.view',
        'reports.export',

        // Users
        'users.view',
        'users.create',
        'users.edit',
        'users.delete',
        'users.block',

        // Activity Logs
        'activities.view',

        // Settings
        'settings.view',
        'settings.update',

    ],

    'admin' => [

        'dashboard.view',

        'customers.view',
        'customers.create',
        'customers.edit',

        'deposits.view',
        'deposits.create',

        'withdrawals.view',
        'withdrawals.create',

        'expenses.view',
        'expenses.create',

        'items.view',
        'items.create',

        'reports.view',
        'reports.export',

    ],

    'manager' => [

        'dashboard.view',

        'customers.view',
        'customers.create',
        'customers.edit',

        'deposits.view',
        'deposits.create',

        'withdrawals.view',
        'withdrawals.create',

        'expenses.view',
        'expenses.create',

        'reports.view',

    ],

    'cashier' => [

        'dashboard.view',

        'customers.view',
        'customers.create',

        'deposits.view',
        'deposits.create',

        'withdrawals.view',
        'withdrawals.create',

    ]

];