<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Customer;
use App\Core\Auth;

class CustomerService
{
    private Customer $customer;


    public function __construct()
    {
        $this->customer = new Customer();
    }


    /**
     * Get all customers.
     */
    public function all(): array
    {
        return $this->customer->all();
    }


    /**
     * Find customer by ID.
     */
    public function find(int $id): ?array
    {
        return $this->customer->find($id);
    }


    /**
     * Get complete customer profile.
     *
     * Includes:
     * - Customer details
     * - Total deposits
     * - Total withdrawals
     * - Total deposit charges
     * - Total withdrawal charges
     * - Total combined charges
     * - Current balance
     * - Total transactions
     */
    public function profile(int $id): ?array
    {
        return $this->customer->profile($id);
    }


    /**
     * Search customers.
     */
    public function search(?string $keyword): array
    {
        $keyword = trim((string) $keyword);

        if ($keyword === '') {
            return $this->customer->all();
        }

        return $this->customer->search($keyword);
    }


    /**
     * Create customer.
     */
    public function create(array $data): bool
    {
        $email = trim(
            (string) ($data['email'] ?? '')
        );

        $phone = trim(
            (string) ($data['phone'] ?? '')
        );


        /*
        |--------------------------------------------------------------------------
        | Check Duplicate Email
        |--------------------------------------------------------------------------
        */

        if (
            $email !== '' &&
            $this->customer->emailExists($email)
        ) {
            throw new \Exception(
                'A customer with this email already exists.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Check Duplicate Phone
        |--------------------------------------------------------------------------
        */

        if (
            $phone !== '' &&
            $this->customer->phoneExists($phone)
        ) {
            throw new \Exception(
                'A customer with this phone number already exists.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Generate Customer Code
        |--------------------------------------------------------------------------
        */

        $data['customer_code'] =
            $this->customer->generateCode();


        /*
        |--------------------------------------------------------------------------
        | Default Values
        |--------------------------------------------------------------------------
        */

        $data['picture'] =
            $data['picture'] ?? 'default.png';

        $data['status'] =
            $data['status'] ?? 'Active';


        /*
        |--------------------------------------------------------------------------
        | Created By
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        $data['created_by'] =
            $user['id'] ?? null;


        return $this->customer->create($data);
    }


    /**
     * Update customer.
     */
    public function update(
        int $id,
        array $data
    ): bool {

        /*
        |--------------------------------------------------------------------------
        | Check Duplicate Email
        |--------------------------------------------------------------------------
        */

        $email = trim(
            (string) ($data['email'] ?? '')
        );

        if (
            $email !== '' &&
            $this->customer->emailExists(
                $email,
                $id
            )
        ) {
            throw new \Exception(
                'A customer with this email already exists.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Check Duplicate Phone
        |--------------------------------------------------------------------------
        */

        $phone = trim(
            (string) ($data['phone'] ?? '')
        );

        if (
            $phone !== '' &&
            $this->customer->phoneExists(
                $phone,
                $id
            )
        ) {
            throw new \Exception(
                'A customer with this phone number already exists.'
            );
        }


        /*
        |--------------------------------------------------------------------------
        | Updated By
        |--------------------------------------------------------------------------
        */

        $user = Auth::user();

        $data['updated_by'] =
            $user['id'] ?? null;


        return $this->customer->update(
            $id,
            $data
        );
    }


    /**
     * Delete customer.
     */
    public function delete(int $id): bool
    {
        return $this->customer->delete($id);
    }


    /**
     * Total customers.
     */
    public function count(): int
    {
        return $this->customer->count();
    }


    /**
     * Customer statistics.
     */
    public function stats(): array
    {
        $customers =
            $this->customer->all();


        $stats = [

            'total' =>
                count($customers),

            'active' =>
                0,

            'inactive' =>
                0,

            'monthly' =>
                0,

        ];


        foreach ($customers as $customer) {

            if (
                ($customer['status'] ?? '')
                === 'Active'
            ) {

                $stats['active']++;

            } else {

                $stats['inactive']++;
            }


            if (
                !empty(
                    $customer['created_at']
                )

                &&

                date(
                    'Y-m',
                    strtotime(
                        $customer['created_at']
                    )
                )

                ===

                date('Y-m')
            ) {

                $stats['monthly']++;
            }
        }


        return $stats;
    }


    /**
     * Get total deposits for customer.
     */
    public function totalDeposits(
        int $customerId
    ): float {

        return $this->customer
            ->totalDeposits(
                $customerId
            );
    }


    /**
     * Get total withdrawals for customer.
     */
    public function totalWithdrawals(
        int $customerId
    ): float {

        return $this->customer
            ->totalWithdrawals(
                $customerId
            );
    }


    /**
     * Get total deposit charges.
     */
    public function totalDepositCharges(
        int $customerId
    ): float {

        return $this->customer
            ->totalDepositCharges(
                $customerId
            );
    }


    /**
     * Get total withdrawal charges.
     */
    public function totalWithdrawalCharges(
        int $customerId
    ): float {

        return $this->customer
            ->totalWithdrawalCharges(
                $customerId
            );
    }


    /**
     * Get total combined charges.
     */
    public function totalCharges(
        int $customerId
    ): float {

        return $this->customer
            ->totalCharges(
                $customerId
            );
    }


    /**
     * Get current customer balance.
     *
     * Balance =
     * Total Deposits - Total Withdrawals
     */
    public function currentBalance(
        int $customerId
    ): float {

        return

            $this->totalDeposits(
                $customerId
            )

            -

            $this->totalWithdrawals(
                $customerId
            );
    }


    /**
     * Get total transaction count.
     */
    public function transactionCount(
        int $customerId
    ): int {

        return $this->customer
            ->transactionCount(
                $customerId
            );
    }
}
?>
