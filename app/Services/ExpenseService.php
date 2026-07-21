<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Expense;
use DateTime;
use InvalidArgumentException;

class ExpenseService
{
    private Expense $expenseModel;


    /**
     * Allowed expense categories.
     */
    private const CATEGORIES = [

        'Rent',

        'Salary',

        'Utilities',

        'Transportation',

        'Office Supplies',

        'Maintenance',

        'Marketing',

        'Other',

    ];


    /**
     * Allowed payment methods.
     */
    private const PAYMENT_METHODS = [

        'Cash',

        'Bank Transfer',

        'POS',

        'Card',

        'Other',

    ];


    /**
     * ExpenseService constructor.
     */
    public function __construct()
    {
        $this->expenseModel =
            new Expense();
    }


    /**
     * Get all expenses.
     */
    public function getAllExpenses(): array
    {
        return $this
            ->expenseModel
            ->all();
    }


    /**
     * Get one expense.
     */
    public function getExpense(
        int $id
    ): ?array {

        if ($id <= 0) {

            throw new InvalidArgumentException(
                'Invalid expense ID.'
            );

        }

        return $this
            ->expenseModel
            ->find($id);
    }


    /**
     * Create a new expense.
     */
    public function createExpense(
        array $data
    ): bool {

        $validatedData =
            $this->validate(
                $data
            );


        return $this
            ->expenseModel
            ->create(
                $validatedData
            );
    }


    /**
     * Update an existing expense.
     */
    public function updateExpense(
        int $id,
        array $data
    ): bool {

        if ($id <= 0) {

            throw new InvalidArgumentException(
                'Invalid expense ID.'
            );

        }


        $expense =
            $this
                ->expenseModel
                ->find($id);


        if (!$expense) {

            throw new InvalidArgumentException(
                'Expense not found.'
            );

        }


        $validatedData =
            $this->validate(
                $data
            );


        return $this
            ->expenseModel
            ->update(
                $id,
                $validatedData
            );
    }


    /**
     * Delete an expense.
     */
    public function deleteExpense(
        int $id
    ): bool {

        if ($id <= 0) {

            throw new InvalidArgumentException(
                'Invalid expense ID.'
            );

        }


        $expense =
            $this
                ->expenseModel
                ->find($id);


        if (!$expense) {

            throw new InvalidArgumentException(
                'Expense not found.'
            );

        }


        return $this
            ->expenseModel
            ->delete(
                $id
            );
    }


    /**
     * Get total expenses.
     */
    public function getTotalExpenses(): float
    {
        return (float) $this
            ->expenseModel
            ->total();
    }


    /**
     * Get today's total expenses.
     */
    public function getTodayTotalExpenses(): float
    {
        return (float) $this
            ->expenseModel
            ->todayTotal();
    }


    /**
     * Validate expense data.
     */
    private function validate(
        array $data
    ): array {


        /*
        |--------------------------------------------------------------------------
        | Category
        |--------------------------------------------------------------------------
        */

        $category =
            trim(
                (string) (
                    $data['category']
                    ?? ''
                )
            );


        if ($category === '') {

            throw new InvalidArgumentException(
                'Expense category is required.'
            );

        }


        if (
            !in_array(
                $category,
                self::CATEGORIES,
                true
            )
        ) {

            throw new InvalidArgumentException(
                'Invalid expense category.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Description
        |--------------------------------------------------------------------------
        */

        $description =
            trim(
                (string) (
                    $data['description']
                    ?? ''
                )
            );


        if (
            mb_strlen(
                $description
            ) > 1000
        ) {

            throw new InvalidArgumentException(
                'Expense description cannot exceed 1000 characters.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Amount
        |--------------------------------------------------------------------------
        */

        $amount =
            $data['amount']
            ?? null;


        if (
            $amount === null
            || $amount === ''
        ) {

            throw new InvalidArgumentException(
                'Expense amount is required.'
            );

        }


        if (
            !is_numeric(
                $amount
            )
        ) {

            throw new InvalidArgumentException(
                'Expense amount must be a valid number.'
            );

        }


        $amount =
            (float) $amount;


        if (
            !is_finite(
                $amount
            )
        ) {

            throw new InvalidArgumentException(
                'Invalid expense amount.'
            );

        }


        if (
            $amount <= 0
        ) {

            throw new InvalidArgumentException(
                'Expense amount must be greater than zero.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Payment Method
        |--------------------------------------------------------------------------
        */

        $paymentMethod =
            trim(
                (string) (
                    $data[
                        'payment_method'
                    ]
                    ?? ''
                )
            );


        if (
            $paymentMethod === ''
        ) {

            throw new InvalidArgumentException(
                'Payment method is required.'
            );

        }


        if (
            !in_array(
                $paymentMethod,
                self::PAYMENT_METHODS,
                true
            )
        ) {

            throw new InvalidArgumentException(
                'Invalid payment method.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Transaction Date
        |--------------------------------------------------------------------------
        */

        $transactionDate =
            trim(
                (string) (
                    $data[
                        'transaction_date'
                    ]
                    ?? ''
                )
            );


        if (
            $transactionDate === ''
        ) {

            throw new InvalidArgumentException(
                'Transaction date is required.'
            );

        }


        $date =
            DateTime::createFromFormat(
                '!Y-m-d',
                $transactionDate
            );


        $dateErrors =
            DateTime::getLastErrors();


        if (
            $date === false
            || (
                $dateErrors !== false
                && (
                    $dateErrors['warning_count']
                    > 0
                    ||
                    $dateErrors['error_count']
                    > 0
                )
            )
            || $date->format(
                'Y-m-d'
            )
            !== $transactionDate
        ) {

            throw new InvalidArgumentException(
                'Invalid transaction date.'
            );

        }


        /*
        |--------------------------------------------------------------------------
        | Created By
        |--------------------------------------------------------------------------
        */

        $createdBy =
            $data[
                'created_by'
            ]
            ?? null;


        if (
            $createdBy !== null
            && $createdBy !== ''
        ) {


            if (
                filter_var(
                    $createdBy,
                    FILTER_VALIDATE_INT
                ) === false
            ) {

                throw new InvalidArgumentException(
                    'Invalid user ID.'
                );

            }


            $createdBy =
                (int) $createdBy;


            if (
                $createdBy <= 0
            ) {

                throw new InvalidArgumentException(
                    'Invalid user ID.'
                );

            }

        } else {

            $createdBy =
                null;

        }


        /*
        |--------------------------------------------------------------------------
        | Return Clean Validated Data
        |--------------------------------------------------------------------------
        */

        return [

            'category' =>
                $category,


            'description' =>
                $description !== ''
                    ? $description
                    : null,


            'amount' =>
                number_format(
                    $amount,
                    2,
                    '.',
                    ''
                ),


            'payment_method' =>
                $paymentMethod,


            'transaction_date' =>
                $transactionDate,


            'created_by' =>
                $createdBy,

        ];

    }

}