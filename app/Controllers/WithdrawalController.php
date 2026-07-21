<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Authorization;
use App\Core\Controller;
use App\Services\WithdrawalService;
use App\Services\CustomerService;

class WithdrawalController extends Controller
{
    private WithdrawalService $withdrawalService;

    private CustomerService $customerService;


    public function __construct()
    {
        $this->withdrawalService =
            new WithdrawalService();

        $this->customerService =
            new CustomerService();
    }


    /**
     * Display all withdrawals.
     */
    public function index(): void
    {
        Authorization::authorize(
            'withdrawals.view'
        );


        $search = trim(
            $_GET['search'] ?? ''
        );


        $page = max(
            1,
            (int) (
                $_GET['page']
                ?? 1
            )
        );


        $perPage = 10;


        $result =
            $this->withdrawalService
                ->paginate(
                    $page,
                    $perPage,
                    $search
                );


        $stats =
            $this->withdrawalService
                ->stats();


        $this->view(
            'withdrawals/index',
            [

                'title' =>
                    'Withdrawals',

                'withdrawals' =>
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
     * Show create withdrawal form.
     */
    public function create(): void
    {
        Authorization::authorize(
            'withdrawals.create'
        );


        $customers =
            $this->customerService
                ->all();


        $this->view(
            'withdrawals/create',
            [

                'title' =>
                    'Add Withdrawal',

                'customers' =>
                    $customers

            ]
        );
    }


    /**
     * Store withdrawal.
     */
    public function store(): void
    {
        Authorization::authorize(
            'withdrawals.create'
        );


        if (
            $_SERVER['REQUEST_METHOD']
            !== 'POST'
        ) {

            redirect(
                'withdrawals'
            );

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


        $created =
            $this->withdrawalService
                ->create(
                    $data
                );


        if ($created) {

            $_SESSION['success'] =
                'Withdrawal recorded successfully.';

        } else {

            $_SESSION['error'] =
                'Unable to record withdrawal.';

        }


        redirect(
            'withdrawals'
        );
    }


    /**
     * View withdrawal.
     */
    public function show(
        int $id
    ): void {

        Authorization::authorize(
            'withdrawals.view'
        );


        $withdrawal =
            $this->withdrawalService
                ->find(
                    $id
                );


        if (!$withdrawal) {

            $_SESSION['error'] =
                'Withdrawal record not found.';

            redirect(
                'withdrawals'
            );

            return;
        }


        $this->view(
            'withdrawals/show',
            [

                'title' =>
                    'View Withdrawal',

                'withdrawal' =>
                    $withdrawal

            ]
        );
    }


    /**
     * Edit withdrawal.
     */
    public function edit(
        int $id
    ): void {

        Authorization::authorize(
            'withdrawals.edit'
        );


        $withdrawal =
            $this->withdrawalService
                ->find(
                    $id
                );


        if (!$withdrawal) {

            $_SESSION['error'] =
                'Withdrawal record not found.';

            redirect(
                'withdrawals'
            );

            return;
        }


        $customers =
            $this->customerService
                ->all();


        $this->view(
            'withdrawals/edit',
            [

                'title' =>
                    'Edit Withdrawal',

                'withdrawal' =>
                    $withdrawal,

                'customers' =>
                    $customers

            ]
        );
    }


    /**
     * Update withdrawal.
     */
    public function update(
        int $id
    ): void {

        Authorization::authorize(
            'withdrawals.edit'
        );


        if (
            $_SERVER['REQUEST_METHOD']
            !== 'POST'
        ) {

            redirect(
                'withdrawals'
            );

            return;
        }


        $withdrawal =
            $this->withdrawalService
                ->find(
                    $id
                );


        if (!$withdrawal) {

            $_SESSION['error'] =
                'Withdrawal record not found.';

            redirect(
                'withdrawals'
            );

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
            $this->withdrawalService
                ->update(
                    $id,
                    $data
                );


        if ($updated) {

            $_SESSION['success'] =
                'Withdrawal updated successfully.';

        } else {

            $_SESSION['error'] =
                'Unable to update withdrawal.';

        }


        redirect(
            'withdrawals/show/'
            . $id
        );
    }


    /**
     * Delete withdrawal.
     */
    public function delete(
        int $id
    ): void {

        Authorization::authorize(
            'withdrawals.delete'
        );


        $withdrawal =
            $this->withdrawalService
                ->find(
                    $id
                );


        if (!$withdrawal) {

            $_SESSION['error'] =
                'Withdrawal record not found.';

            redirect(
                'withdrawals'
            );

            return;
        }


        $deleted =
            $this->withdrawalService
                ->delete(
                    $id
                );


        if ($deleted) {

            $_SESSION['success'] =
                'Withdrawal deleted successfully.';

        } else {

            $_SESSION['error'] =
                'Unable to delete withdrawal.';

        }


        redirect(
            'withdrawals'
        );
    }
}