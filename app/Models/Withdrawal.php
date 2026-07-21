<?php

declare(strict_types=1);

namespace App\Models;

use Config\Database;
use PDO;

class Withdrawal
{
    private PDO $db;


    public function __construct()
    {
        $this->db = Database::connect();
    }


    /**
     * Get all withdrawals.
     */
    public function all(): array
    {
        $stmt = $this->db->query("
            SELECT
                withdrawals.*,
                customers.fullname,
                customers.customer_code
            FROM withdrawals
            INNER JOIN customers
                ON customers.id = withdrawals.customer_id
            ORDER BY withdrawals.id DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


    /**
     * Get paginated withdrawals with search.
     *
     * Search fields:
     * - Customer name
     * - Customer code
     * - Account name
     * - Account number
     * - Bank name
     * - Description
     */
    public function paginate(
        int $limit,
        int $offset,
        string $search = ''
    ): array {

        /*
        |--------------------------------------------------------------------------
        | Normalize pagination values
        |--------------------------------------------------------------------------
        */

        $limit = max(1, $limit);
        $offset = max(0, $offset);


        /*
        |--------------------------------------------------------------------------
        | Search conditions
        |--------------------------------------------------------------------------
        */

        $where = '';

        $countParams = [];

        $dataParams = [];


        if ($search !== '') {

            $where = "
                WHERE
                    customers.fullname LIKE :fullname_search

                    OR customers.customer_code
                       LIKE :customer_code_search

                    OR withdrawals.account_name
                       LIKE :account_name_search

                    OR withdrawals.account_number
                       LIKE :account_number_search

                    OR withdrawals.bank_name
                       LIKE :bank_name_search

                    OR withdrawals.description
                       LIKE :description_search
            ";


            $searchValue =
                '%' . $search . '%';


            /*
            |--------------------------------------------------------------------------
            | COUNT query parameters
            |--------------------------------------------------------------------------
            */

            $countParams = [

                ':fullname_search' =>
                    $searchValue,

                ':customer_code_search' =>
                    $searchValue,

                ':account_name_search' =>
                    $searchValue,

                ':account_number_search' =>
                    $searchValue,

                ':bank_name_search' =>
                    $searchValue,

                ':description_search' =>
                    $searchValue

            ];


            /*
            |--------------------------------------------------------------------------
            | DATA query parameters
            |--------------------------------------------------------------------------
            */

            $dataParams = $countParams;
        }


        /*
        |--------------------------------------------------------------------------
        | Get total number of matching withdrawals
        |--------------------------------------------------------------------------
        */

        $countSql = "

            SELECT COUNT(*)

            FROM withdrawals

            INNER JOIN customers

                ON customers.id =
                   withdrawals.customer_id

            {$where}

        ";


        $countStmt =
            $this->db->prepare(
                $countSql
            );


        $countStmt->execute(
            $countParams
        );


        $total =
            (int) $countStmt->fetchColumn();


        /*
        |--------------------------------------------------------------------------
        | Get paginated records
        |--------------------------------------------------------------------------
        */

        /*
        |--------------------------------------------------------------------------
        | LIMIT and OFFSET are safely cast to integers before being placed
        | directly into the query.
        |--------------------------------------------------------------------------
        */

        $sql = "

            SELECT

                withdrawals.*,

                customers.fullname,

                customers.customer_code

            FROM withdrawals

            INNER JOIN customers

                ON customers.id =
                   withdrawals.customer_id

            {$where}

            ORDER BY withdrawals.id DESC

            LIMIT {$limit}

            OFFSET {$offset}

        ";


        $stmt =
            $this->db->prepare(
                $sql
            );


        $stmt->execute(
            $dataParams
        );


        return [

            'data' =>
                $stmt->fetchAll(
                    PDO::FETCH_ASSOC
                ),

            'total' =>
                $total

        ];
    }


    /**
     * Find withdrawal by ID.
     */
    public function find(
        int $id
    ): ?array {

        $stmt = $this->db->prepare("

            SELECT

                withdrawals.*,

                customers.fullname,

                customers.customer_code

            FROM withdrawals

            INNER JOIN customers

                ON customers.id =
                   withdrawals.customer_id

            WHERE withdrawals.id =
                  :id

            LIMIT 1

        ");


        $stmt->execute([

            ':id' =>
                $id

        ]);


        $withdrawal =
            $stmt->fetch(
                PDO::FETCH_ASSOC
            );


        return $withdrawal ?: null;
    }


    /**
     * Create withdrawal.
     */
    public function create(
        array $data
    ): bool {

        $stmt = $this->db->prepare("

            INSERT INTO withdrawals (

                customer_id,

                account_name,

                account_number,

                bank_name,

                amount,

                charges,

                description,

                transaction_date,

                created_by

            )

            VALUES (

                :customer_id,

                :account_name,

                :account_number,

                :bank_name,

                :amount,

                :charges,

                :description,

                :transaction_date,

                :created_by

            )

        ");


        return $stmt->execute([

            ':customer_id' =>
                $data['customer_id'],

            ':account_name' =>
                $data['account_name'],

            ':account_number' =>
                $data['account_number']
                ?? null,

            ':bank_name' =>
                $data['bank_name']
                ?? null,

            ':amount' =>
                $data['amount'],

            ':charges' =>
                $data['charges']
                ?? 0,

            ':description' =>
                $data['description']
                ?? null,

            ':transaction_date' =>
                $data['transaction_date'],

            ':created_by' =>
                $data['created_by']

        ]);
    }


    /**
     * Update withdrawal.
     */
    public function update(
        int $id,
        array $data
    ): bool {

        $stmt = $this->db->prepare("

            UPDATE withdrawals

            SET

                customer_id =
                    :customer_id,

                account_name =
                    :account_name,

                account_number =
                    :account_number,

                bank_name =
                    :bank_name,

                amount =
                    :amount,

                charges =
                    :charges,

                description =
                    :description,

                transaction_date =
                    :transaction_date

            WHERE id = :id

        ");


        return $stmt->execute([

            ':id' =>
                $id,

            ':customer_id' =>
                $data['customer_id'],

            ':account_name' =>
                $data['account_name'],

            ':account_number' =>
                $data['account_number']
                ?? null,

            ':bank_name' =>
                $data['bank_name']
                ?? null,

            ':amount' =>
                $data['amount'],

            ':charges' =>
                $data['charges']
                ?? 0,

            ':description' =>
                $data['description']
                ?? null,

            ':transaction_date' =>
                $data['transaction_date']

        ]);
    }


    /**
     * Delete withdrawal.
     */
    public function delete(
        int $id
    ): bool {

        $stmt = $this->db->prepare("

            DELETE FROM withdrawals

            WHERE id = :id

        ");


        return $stmt->execute([

            ':id' =>
                $id

        ]);
    }


    /**
     * Get total withdrawals for a customer.
     */
    public function totalByCustomer(
        int $customerId
    ): float {

        $stmt = $this->db->prepare("

            SELECT COALESCE(

                SUM(amount),

                0

            )

            FROM withdrawals

            WHERE customer_id =
                  :customer_id

        ");


        $stmt->execute([

            ':customer_id' =>
                $customerId

        ]);


        return (float)
            $stmt->fetchColumn();
    }


    /**
     * Count withdrawals.
     */
    public function count(): int
    {
        $stmt = $this->db->query("

            SELECT COUNT(*)

            FROM withdrawals

        ");


        return (int)
            $stmt->fetchColumn();
    }


    /**
     * Get withdrawal statistics.
     */
    public function stats(): array
    {
        $stmt = $this->db->query("

            SELECT

                COUNT(*) AS total,

                COALESCE(

                    SUM(amount),

                    0

                ) AS total_amount,

                COALESCE(

                    SUM(charges),

                    0

                ) AS total_charges,

                COALESCE(

                    SUM(

                        CASE

                            WHEN MONTH(
                                transaction_date
                            )
                            =
                            MONTH(
                                CURRENT_DATE()
                            )

                            AND YEAR(
                                transaction_date
                            )
                            =
                            YEAR(
                                CURRENT_DATE()
                            )

                            THEN amount

                            ELSE 0

                        END

                    ),

                    0

                ) AS monthly_amount

            FROM withdrawals

        ");


        return $stmt->fetch(
            PDO::FETCH_ASSOC
        ) ?: [

            'total' =>
                0,

            'total_amount' =>
                0,

            'total_charges' =>
                0,

            'monthly_amount' =>
                0

        ];
    }
}
?>
