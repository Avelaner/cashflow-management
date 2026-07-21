<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Authorization;
use App\Core\Controller;
use App\Services\CustomerService;

class CustomerController extends Controller
{
    private CustomerService $customerService;


    public function __construct()
    {
        $this->customerService = new CustomerService();
    }


    /**
     * Customer List
     */
    public function index(): void
    {
        Authorization::authorize('customers.view');

        $search = trim(
            $_GET['search'] ?? ''
        );

        $customers =
            $this->customerService
                ->search($search);

        $stats =
            $this->customerService
                ->stats();

        $this->view(
            'customers/index',
            [
                'title' => 'Customers',
                'customers' => $customers,
                'stats' => $stats,
                'search' => $search
            ]
        );
    }


    /**
     * Show Create Form
     */
    public function create(): void
    {
        Authorization::authorize(
            'customers.create'
        );

        $this->view(
            'customers/create',
            [
                'title' => 'Add Customer'
            ]
        );
    }


    /**
     * Store Customer
     */
    public function store(): void
    {
        Authorization::authorize(
            'customers.create'
        );

        if (
            $_SERVER['REQUEST_METHOD']
            !== 'POST'
        ) {
            redirect('customers');
        }

        $picture = 'default.png';

        /*
        |--------------------------------------------------------------------------
        | Upload Customer Picture
        |--------------------------------------------------------------------------
        */

        if (
            isset($_FILES['picture']) &&
            $_FILES['picture']['error']
            === UPLOAD_ERR_OK
        ) {
            $extension = strtolower(
                pathinfo(
                    $_FILES['picture']['name'],
                    PATHINFO_EXTENSION
                )
            );

            $allowed = [
                'jpg',
                'jpeg',
                'png',
                'webp'
            ];

            if (
                in_array(
                    $extension,
                    $allowed,
                    true
                )
            ) {
                $picture =
                    uniqid(
                        'customer_',
                        true
                    )
                    . '.'
                    . $extension;

                $destination =
                    BASE_PATH
                    . '/public/assets/uploads/customers/'
                    . $picture;

                move_uploaded_file(
                    $_FILES['picture']['tmp_name'],
                    $destination
                );
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Customer Data
        |--------------------------------------------------------------------------
        */

        $data = [

            'fullname' =>
                trim(
                    $_POST['fullname']
                    ?? ''
                ),

            'gender' =>
                trim(
                    $_POST['gender']
                    ?? ''
                ),

            'phone' =>
                trim(
                    $_POST['phone']
                    ?? ''
                ),

            'email' =>
                trim(
                    $_POST['email']
                    ?? ''
                ),

            'address' =>
                trim(
                    $_POST['address']
                    ?? ''
                ),

            'occupation' =>
                trim(
                    $_POST['occupation']
                    ?? ''
                ),

            'status' =>
                trim(
                    $_POST['status']
                    ?? 'Active'
                ),

            'picture' =>
                $picture
        ];


        try {

            $this->customerService
                ->create($data);

            $_SESSION['flash'] = [

                'type' =>
                    'success',

                'message' =>
                    'Customer registered successfully.'

            ];

        } catch (\Throwable $e) {

            $_SESSION['flash'] = [

                'type' =>
                    'danger',

                'message' =>
                    $e->getMessage()

            ];
        }

        redirect('customers');
    }


    /**
     * View Customer Profile
     *
     * IMPORTANT:
     * Use profile(), not find().
     *
     * profile() loads:
     * - Total deposits
     * - Total withdrawals
     * - Total charges
     * - Total transactions
     */
    public function show(
        int $id
    ): void {

        Authorization::authorize(
            'customers.view'
        );

        $customer =
            $this->customerService
                ->profile($id);

        if (!$customer) {

            $_SESSION['flash'] = [

                'type' =>
                    'danger',

                'message' =>
                    'Customer not found.'

            ];

            redirect('customers');

            return;
        }

        $this->view(
            'customers/show',
            [

                'title' =>
                    'Customer Profile',

                'customer' =>
                    $customer

            ]
        );
    }


    /**
     * Edit Customer
     */
    public function edit(
        int $id
    ): void {

        Authorization::authorize(
            'customers.edit'
        );

        $customer =
            $this->customerService
                ->find($id);

        if (!$customer) {

            $_SESSION['flash'] = [

                'type' =>
                    'danger',

                'message' =>
                    'Customer not found.'

            ];

            redirect('customers');

            return;
        }

        $this->view(
            'customers/edit',
            [

                'title' =>
                    'Edit Customer',

                'customer' =>
                    $customer

            ]
        );
    }


    /**
     * Update Customer
     */
    public function update(
        int $id
    ): void {

        Authorization::authorize(
            'customers.edit'
        );

        if (
            $_SERVER['REQUEST_METHOD']
            !== 'POST'
        ) {
            redirect('customers');
        }

        $customer =
            $this->customerService
                ->find($id);

        if (!$customer) {

            $_SESSION['flash'] = [

                'type' =>
                    'danger',

                'message' =>
                    'Customer not found.'

            ];

            redirect('customers');

            return;
        }


        /*
        |--------------------------------------------------------------------------
        | Keep Existing Picture
        |--------------------------------------------------------------------------
        */

        $picture =
            $customer['picture']
            ?? 'default.png';


        /*
        |--------------------------------------------------------------------------
        | Upload New Picture
        |--------------------------------------------------------------------------
        */

        if (
            isset($_FILES['picture']) &&
            $_FILES['picture']['error']
            === UPLOAD_ERR_OK
        ) {

            $extension = strtolower(
                pathinfo(
                    $_FILES['picture']['name'],
                    PATHINFO_EXTENSION
                )
            );

            $allowed = [

                'jpg',
                'jpeg',
                'png',
                'webp'

            ];

            if (
                in_array(
                    $extension,
                    $allowed,
                    true
                )
            ) {

                $newPicture =
                    uniqid(
                        'customer_',
                        true
                    )
                    . '.'
                    . $extension;


                $destination =
                    BASE_PATH
                    . '/public/assets/uploads/customers/'
                    . $newPicture;


                if (
                    move_uploaded_file(
                        $_FILES['picture']['tmp_name'],
                        $destination
                    )
                ) {

                    /*
                    |--------------------------------------------------------------------------
                    | Delete Old Picture
                    |--------------------------------------------------------------------------
                    */

                    if (
                        !empty(
                            $customer['picture']
                        )
                        &&
                        $customer['picture']
                        !== 'default.png'
                    ) {

                        $oldPicture =
                            BASE_PATH
                            . '/public/assets/uploads/customers/'
                            . $customer['picture'];

                        if (
                            is_file(
                                $oldPicture
                            )
                        ) {
                            unlink(
                                $oldPicture
                            );
                        }
                    }

                    $picture =
                        $newPicture;
                }
            }
        }


        /*
        |--------------------------------------------------------------------------
        | Customer Data
        |--------------------------------------------------------------------------
        */

        $data = [

            'fullname' =>
                trim(
                    $_POST['fullname']
                    ?? ''
                ),

            'gender' =>
                trim(
                    $_POST['gender']
                    ?? ''
                ),

            'phone' =>
                trim(
                    $_POST['phone']
                    ?? ''
                ),

            'email' =>
                trim(
                    $_POST['email']
                    ?? ''
                ),

            'address' =>
                trim(
                    $_POST['address']
                    ?? ''
                ),

            'occupation' =>
                trim(
                    $_POST['occupation']
                    ?? ''
                ),

            'status' =>
                trim(
                    $_POST['status']
                    ?? 'Active'
                ),

            'picture' =>
                $picture
        ];


        try {

            $this->customerService
                ->update(
                    $id,
                    $data
                );

            $_SESSION['flash'] = [

                'type' =>
                    'success',

                'message' =>
                    'Customer updated successfully.'

            ];

        } catch (\Throwable $e) {

            $_SESSION['flash'] = [

                'type' =>
                    'danger',

                'message' =>
                    $e->getMessage()

            ];
        }


        redirect(
            'customers/show/'
            . $id
        );
    }


    /**
     * Delete Customer
     */
    public function delete(
        int $id
    ): void {

        Authorization::authorize(
            'customers.delete'
        );

        $customer =
            $this->customerService
                ->find($id);

        if (!$customer) {

            $_SESSION['flash'] = [

                'type' =>
                    'danger',

                'message' =>
                    'Customer not found.'

            ];

            redirect('customers');

            return;
        }


        try {

            $deleted =
                $this->customerService
                    ->delete($id);

            $_SESSION['flash'] = [

                'type' =>
                    $deleted
                    ? 'success'
                    : 'danger',

                'message' =>
                    $deleted
                    ? 'Customer deleted successfully.'
                    : 'Unable to delete customer.'

            ];

        } catch (\Throwable $e) {

            $_SESSION['flash'] = [

                'type' =>
                    'danger',

                'message' =>
                    'An error occurred while deleting the customer.'

            ];
        }

        redirect('customers');
    }


    /**
     * Deposit Form
     */
    public function deposit(
        int $id
    ): void {

        Authorization::authorize(
            'deposits.create'
        );

        $customer =
            $this->customerService
                ->find($id);

        if (!$customer) {

            redirect('customers');

            return;
        }

        $this->view(
            'customers/deposit',
            [

                'title' =>
                    'Customer Deposit',

                'customer' =>
                    $customer

            ]
        );
    }


    /**
     * Save Deposit
     */
    public function storeDeposit(
        int $id
    ): void {

        Authorization::authorize(
            'deposits.create'
        );

        // Deposit transaction logic goes here.
    }


    /**
     * Withdrawal Form
     */
    public function withdraw(
        int $id
    ): void {

        Authorization::authorize(
            'withdrawals.create'
        );

        $customer =
            $this->customerService
                ->find($id);

        if (!$customer) {

            redirect('customers');

            return;
        }

        $this->view(
            'customers/withdraw',
            [

                'title' =>
                    'Customer Withdrawal',

                'customer' =>
                    $customer

            ]
        );
    }


    /**
     * Save Withdrawal
     */
    public function storeWithdrawal(
        int $id
    ): void {

        Authorization::authorize(
            'withdrawals.create'
        );

        // Withdrawal transaction logic goes here.
    }


    /**
     * Customer Statement
     */
    public function statement(
        int $id
    ): void {

        Authorization::authorize(
            'customers.view'
        );

        $customer =
            $this->customerService
                ->find($id);

        if (!$customer) {

            redirect('customers');

            return;
        }

        $this->view(
            'customers/statement',
            [

                'title' =>
                    'Customer Statement',

                'customer' =>
                    $customer

            ]
        );
    }
}
?>
