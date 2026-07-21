<?php

declare(strict_types=1);

namespace App\Models;

use Config\Database;
use PDO;

class Expense
{
    private PDO $db;


    /**
     * Expense model constructor.
     */
    public function __construct()
    {
        $this->db =
            Database::connect();
    }


    /**
     * Get all expenses with filters.
     *
     * Supported filters:
     *
     * search
     * category
     * payment_method
     * date_from
     * date_to
     */
    public function all(
        array $filters = []
    ): array {

        $sql = "
            SELECT

                expenses.*,

                users.fullname
                    AS created_by_name

            FROM expenses

            LEFT JOIN users
                ON users.id =
                expenses.created_by

            WHERE 1 = 1
        ";


        $params = [];


        /*
        |--------------------------------------------------------------------------
        | Search
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $filters['search']
            )
        ) {

            $sql .= "
                AND (
                    expenses.category
                    LIKE :search_category

                    OR expenses.description
                    LIKE :search_description
                )
            ";


            $search =
                '%'
                . trim(
                    (string)
                    $filters['search']
                )
                . '%';


            $params[
                ':search_category'
            ] =
                $search;


            $params[
                ':search_description'
            ] =
                $search;
        }


        /*
        |--------------------------------------------------------------------------
        | Category Filter
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $filters['category']
            )
        ) {

            $sql .= "
                AND expenses.category =
                    :category
            ";


            $params[
                ':category'
            ] =
                trim(
                    (string)
                    $filters['category']
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Payment Method Filter
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $filters[
                    'payment_method'
                ]
            )
        ) {

            $sql .= "
                AND expenses.payment_method =
                    :payment_method
            ";


            $params[
                ':payment_method'
            ] =
                trim(
                    (string)
                    $filters[
                        'payment_method'
                    ]
                );
        }


        /*
        |--------------------------------------------------------------------------
        | Date From Filter
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $filters['date_from']
            )
        ) {

            $sql .= "
                AND expenses.transaction_date >=
                    :date_from
            ";


            $params[
                ':date_from'
            ] =
                $filters[
                    'date_from'
                ];
        }


        /*
        |--------------------------------------------------------------------------
        | Date To Filter
        |--------------------------------------------------------------------------
        */

        if (
            !empty(
                $filters['date_to']
            )
        ) {

            $sql .= "
                AND expenses.transaction_date <=
                    :date_to
            ";


            $params[
                ':date_to'
            ] =
                $filters[
                    'date_to'
                ];
        }


        /*
        |--------------------------------------------------------------------------
        | Ordering
        |--------------------------------------------------------------------------
        */

        $sql .= "

            ORDER BY
                expenses.id DESC
        ";


        /*
        |--------------------------------------------------------------------------
        | Execute Query
        |--------------------------------------------------------------------------
        */

        $stmt =
            $this->db->prepare(
                $sql
            );


        $stmt->execute(
            $params
        );


        return $stmt->fetchAll(
            PDO::FETCH_ASSOC
        );
    }


    /**
     * Find expense by ID.
     */
    public function find(
        int $id
    ): ?array {

        $stmt =
            $this->db->prepare("

                SELECT

                    expenses.*,

                    users.fullname
                        AS created_by_name

                FROM expenses

                LEFT JOIN users
                    ON users.id =
                    expenses.created_by

                WHERE expenses.id =
                    :id

                LIMIT 1

            ");


        $stmt->execute([

            ':id' =>
                $id,

        ]);


        $expense =
            $stmt->fetch(
                PDO::FETCH_ASSOC
            );


        return $expense
            ?: null;
    }


    /**
     * Create a new expense.
     */
    public function create(
        array $data
    ): bool {

        $stmt =
            $this->db->prepare("

                INSERT INTO expenses (

                    category,

                    description,

                    amount,

                    payment_method,

                    transaction_date,

                    created_by

                )

                VALUES (

                    :category,

                    :description,

                    :amount,

                    :payment_method,

                    :transaction_date,

                    :created_by

                )

            ");


        return $stmt->execute([

            ':category' =>
                $data[
                    'category'
                ],

            ':description' =>
                $data[
                    'description'
                ]
                ?? null,

            ':amount' =>
                $data[
                    'amount'
                ],

            ':payment_method' =>
                $data[
                    'payment_method'
                ]
                ?? null,

            ':transaction_date' =>
                $data[
                    'transaction_date'
                ],

            ':created_by' =>
                $data[
                    'created_by'
                ]
                ?? null,

        ]);
    }


    /**
     * Update an expense.
     */
    public function update(
        int $id,
        array $data
    ): bool {

        $stmt =
            $this->db->prepare("

                UPDATE expenses

                SET

                    category =
                        :category,

                    description =
                        :description,

                    amount =
                        :amount,

                    payment_method =
                        :payment_method,

                    transaction_date =
                        :transaction_date

                WHERE id =
                    :id

            ");


        return $stmt->execute([

            ':id' =>
                $id,

            ':category' =>
                $data[
                    'category'
                ],

            ':description' =>
                $data[
                    'description'
                ]
                ?? null,

            ':amount' =>
                $data[
                    'amount'
                ],

            ':payment_method' =>
                $data[
                    'payment_method'
                ]
                ?? null,

            ':transaction_date' =>
                $data[
                    'transaction_date'
                ],

        ]);
    }


    /**
     * Delete an expense.
     */
    public function delete(
        int $id
    ): bool {

        $stmt =
            $this->db->prepare("

                DELETE FROM expenses

                WHERE id =
                    :id

            ");


        return $stmt->execute([

            ':id' =>
                $id,

        ]);
    }


    /**
     * Get total expenses.
     */
    public function total(): float
    {
        $stmt =
            $this->db->query("

                SELECT

                    COALESCE(
                        SUM(amount),
                        0
                    )

                FROM expenses

            ");


        return (float)
            $stmt->fetchColumn();
    }


    /**
     * Get total expenses for today.
     */
    public function todayTotal(): float
    {
        $stmt =
            $this->db->query("

                SELECT

                    COALESCE(
                        SUM(amount),
                        0
                    )

                FROM expenses

                WHERE transaction_date =
                    CURDATE()

            ");


        return (float)
            $stmt->fetchColumn();
    }
}