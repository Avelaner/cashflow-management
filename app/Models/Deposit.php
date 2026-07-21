<?php

declare(strict_types=1);

namespace App\Models;

use Config\Database;
use PDO;

class Deposit
{
    private PDO $db;


    public function __construct()
    {
        $this->db = Database::connect();
    }


    /**
     * Get all deposits.
     */
    public function all(): array
    {
        $stmt = $this->db->query("
            SELECT
                deposits.*,
                customers.fullname,
                customers.customer_code

            FROM deposits

            INNER JOIN customers
                ON customers.id = deposits.customer_id

            ORDER BY deposits.id DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
 * Get paginated deposits with search.
 */
public function paginate(
    int $limit,
    int $offset,
    string $search = ''
): array {

    $where = '';
    $params = [];


    if ($search !== '') {

       $where = "
    WHERE
        customers.fullname LIKE :search_fullname
        OR customers.customer_code LIKE :search_code
        OR deposits.account_name LIKE :search_account
        OR deposits.account_number LIKE :search_account_number
        OR deposits.bank_name LIKE :search_bank
        OR deposits.description LIKE :search_description
";

$params = [

    'search_fullname' =>
        '%' . $search . '%',

    'search_code' =>
        '%' . $search . '%',

    'search_account' =>
        '%' . $search . '%',

    'search_account_number' =>
        '%' . $search . '%',

    'search_bank' =>
        '%' . $search . '%',

    'search_description' =>
        '%' . $search . '%'

];
    }


    $countSql = "
        SELECT COUNT(*)

        FROM deposits

        INNER JOIN customers
            ON customers.id = deposits.customer_id

        $where
    ";


    $countStmt = $this->db->prepare($countSql);

    $countStmt->execute($params);

    $total = (int) $countStmt->fetchColumn();


    $sql = "
        SELECT

            deposits.*,

            customers.fullname,

            customers.customer_code

        FROM deposits

        INNER JOIN customers
            ON customers.id = deposits.customer_id

        $where

        ORDER BY deposits.id DESC

        LIMIT :limit

        OFFSET :offset
    ";


    $stmt = $this->db->prepare($sql);


    foreach ($params as $key => $value) {

        $stmt->bindValue(
            ':' . $key,
            $value,
            PDO::PARAM_STR
        );
    }


    $stmt->bindValue(
        ':limit',
        $limit,
        PDO::PARAM_INT
    );


    $stmt->bindValue(
        ':offset',
        $offset,
        PDO::PARAM_INT
    );


    $stmt->execute();


    return [

        'data' =>
            $stmt->fetchAll(PDO::FETCH_ASSOC),

        'total' =>
            $total

    ];
}


    /**
     * Find deposit by ID.
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT
                deposits.*,
                customers.fullname,
                customers.customer_code

            FROM deposits

            INNER JOIN customers
                ON customers.id = deposits.customer_id

            WHERE deposits.id = :id

            LIMIT 1
        ");

        $stmt->execute([
            'id' => $id
        ]);

        $deposit = $stmt->fetch(PDO::FETCH_ASSOC);

        return $deposit ?: null;
    }


    /**
     * Create deposit.
     */
   public function create(array $data): bool
{
    $stmt = $this->db->prepare("
        INSERT INTO deposits (

            customer_id,
            account_name,
            account_number,
            bank_name,
            amount,
            charges,
            description,
            transaction_date,
            created_by

        ) VALUES (

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
            $data['account_number'],

        ':bank_name' =>
            $data['bank_name'],

        ':amount' =>
            $data['amount'],

        ':charges' =>
            $data['charges'] ?? 0,

        ':description' =>
            $data['description'] ?? null,

        ':transaction_date' =>
            $data['transaction_date'],

        ':created_by' =>
            $data['created_by']

    ]);
}


    /**
     * Update deposit.
     */
   public function update(
    int $id,
    array $data
): bool {

    $stmt = $this->db->prepare("

        UPDATE deposits

        SET

            customer_id = :customer_id,

            account_name = :account_name,

            account_number = :account_number,

            bank_name = :bank_name,

            amount = :amount,

            charges = :charges,

            description = :description,

            transaction_date = :transaction_date

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
            $data['account_number'],

        ':bank_name' =>
            $data['bank_name'],

        ':amount' =>
            $data['amount'],

        ':charges' =>
            $data['charges'] ?? 0,

        ':description' =>
            $data['description'] ?? null,

        ':transaction_date' =>
            $data['transaction_date']

    ]);
}


    /**
     * Delete deposit.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("
            DELETE FROM deposits
            WHERE id = :id
        ");

        return $stmt->execute([
            'id' => $id
        ]);
    }


    /**
     * Total deposits for a customer.
     */
    public function totalByCustomer(
        int $customerId
    ): float {

        $stmt = $this->db->prepare("
            SELECT COALESCE(
                SUM(amount),
                0
            )

            FROM deposits

            WHERE customer_id = :customer_id
        ");

        $stmt->execute([
            'customer_id' => $customerId
        ]);

        return (float) $stmt->fetchColumn();
    }


    /**
     * Count deposits.
     */
    public function count(): int
    {
        $stmt = $this->db->query("
            SELECT COUNT(*)
            FROM deposits
        ");

        return (int) $stmt->fetchColumn();
    }


    /**
 * Get deposit statistics.
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

                        WHEN MONTH(transaction_date)
                            = MONTH(CURRENT_DATE())

                        AND YEAR(transaction_date)
                            = YEAR(CURRENT_DATE())

                        THEN amount

                        ELSE 0

                    END

                ),

                0

            ) AS monthly_amount

        FROM deposits
    ");


    return $stmt->fetch(PDO::FETCH_ASSOC) ?: [

        'total' => 0,

        'total_amount' => 0,

        'total_charges' => 0,

        'monthly_amount' => 0

    ];
}
}