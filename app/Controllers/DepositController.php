<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Authorization;
use App\Core\Controller;
use App\Services\DepositService;
use App\Services\CustomerService;

class DepositController extends Controller
{
    private DepositService $depositService;

    private CustomerService $customerService;

    public function __construct()
    {
        $this->depositService =
            new DepositService();

        $this->customerService =
            new CustomerService();
    }


    /**
     * Display all deposits.
     */
   /**
 * Deposit / Transfer List
 */
public function index(): void
{
    Authorization::authorize('deposits.view');

    $search = trim(
        $_GET['search'] ?? ''
    );

    $page = max(
        1,
        (int) ($_GET['page'] ?? 1)
    );

    $perPage = 10;


    $result =
        $this->depositService->paginate(
            $page,
            $perPage,
            $search
        );


    $stats =
        $this->depositService->stats();


    $this->view(
        'deposits/index',
        [

            'title' =>
                'Deposits / Transfer',

            'deposits' =>
                $result['data'],

            'stats' =>
                $stats,

            'total' =>
                $result['total'],

            'page' =>
                $result['page'],

            'perPage' =>
                $result['perPage'],

            'totalPages' =>
                $result['totalPages'],

            'search' =>
                $search

        ]
    );
}


    /**
     * Show create deposit form.
     */
    public function create(): void
    {
        Authorization::authorize(
            'deposits.create'
        );

        $customers =
            $this->customerService->all();

        $this->view(
            'deposits/create',
            [

                'title' =>
                    'Add Deposit / Transfer',

                'customers' =>
                    $customers

            ]
        );
    }


    /**
     * Store deposit.
     */
    public function store(): void
    {
        Authorization::authorize(
            'deposits.create'
        );


        if (
            $_SERVER['REQUEST_METHOD']
            !== 'POST'
        ) {

            redirect('deposits');

        }


        $data = [

    'customer_id' =>
        (int) (
            $_POST['customer_id']
            ?? 0
        ),

    'account_name' =>
        trim(
            $_POST['account_name']
            ?? ''
        ),

    'account_number' =>
        trim(
            $_POST['account_number']
            ?? ''
        ),

    'bank_name' =>
        trim(
            $_POST['bank_name']
            ?? ''
        ),

    'amount' =>
        (float) (
            $_POST['amount']
            ?? 0
        ),

    'charges' =>
        (float) (
            $_POST['charges']
            ?? 0
        ),

    'description' =>
        trim(
            $_POST['description']
            ?? ''
        ),

    'transaction_date' =>
        $_POST['transaction_date']
        ?? date('Y-m-d')

];


        $this->depositService
            ->create($data);


        redirect('deposits');
    }


    /**
     * View deposit.
     */
    public function show(int $id): void
    {
        Authorization::authorize(
            'deposits.view'
        );


        $deposit =
            $this->depositService
                ->find($id);


        if (!$deposit) {

            die(
                'Deposit not found.'
            );

        }


        $this->view(
            'deposits/show',
            [

                'title' =>
                    'View Deposit',

                'deposit' =>
                    $deposit

            ]
        );
    }


    /**
     * Edit deposit.
     */
    public function edit(int $id): void
    {
        Authorization::authorize(
            'deposits.edit'
        );


        $deposit =
            $this->depositService
                ->find($id);


        if (!$deposit) {

            die(
                'Deposit not found.'
            );

        }


        $customers =
            $this->customerService->all();


        $this->view(
            'deposits/edit',
            [

                'title' =>
                    'Edit Deposit',

                'deposit' =>
                    $deposit,

                'customers' =>
                    $customers

            ]
        );
    }


    /**
     * Update deposit.
     */
    /**
 * Update deposit.
 */
public function update(int $id): void
{
    Authorization::authorize(
        'deposits.edit'
    );

    if (
        $_SERVER['REQUEST_METHOD']
        !== 'POST'
    ) {
        redirect('deposits');

        return;
    }


    $deposit =
        $this->depositService
            ->find($id);


    if (!$deposit) {

        $_SESSION['error'] =
            'Deposit record not found.';

        redirect('deposits');

        return;
    }


   $data = [

    'customer_id' =>
        (int) (
            $_POST['customer_id']
            ?? 0
        ),

    'account_name' =>
        trim(
            $_POST['account_name']
            ?? ''
        ),

    'account_number' =>
        trim(
            $_POST['account_number']
            ?? ''
        ),

    'bank_name' =>
        trim(
            $_POST['bank_name']
            ?? ''
        ),

    'amount' =>
        (float) (
            $_POST['amount']
            ?? 0
        ),

    'charges' =>
        (float) (
            $_POST['charges']
            ?? 0
        ),

    'description' =>
        trim(
            $_POST['description']
            ?? ''
        ),

    'transaction_date' =>
        $_POST['transaction_date']
        ?? date('Y-m-d')

];


    $updated =
        $this->depositService
            ->update(
                $id,
                $data
            );


    if ($updated) {

        $_SESSION['success'] =
            'Deposit updated successfully.';

    } else {

        $_SESSION['error'] =
            'Unable to update deposit.';

    }


    redirect(
        'deposits/show/'
        . $id
    );
}


    /**
     * Delete deposit.
     */
   /**
 * Delete deposit.
 */
public function delete(int $id): void
{
    Authorization::authorize(
        'deposits.delete'
    );


    $deposit =
        $this->depositService
            ->find($id);


    if (!$deposit) {

        $_SESSION['error'] =
            'Deposit record not found.';

        redirect('deposits');

        return;
    }


    $deleted =
        $this->depositService
            ->delete($id);


    if ($deleted) {

        $_SESSION['success'] =
            'Deposit deleted successfully.';

    } else {

        $_SESSION['error'] =
            'Unable to delete deposit.';

    }


    redirect('deposits');
}


}