<?php

declare(strict_types=1);

namespace App\Models;

use Config\Database;
use PDO;

class Customer
{
    private PDO $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Get all customers.
     */
    public function all(): array
    {
        $stmt = $this->db->query("
            SELECT *
            FROM customers
            ORDER BY id DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Get complete customer profile.
     */
    public function profile(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT
                c.*,
                COALESCE(dep.total_deposits, 0) AS total_deposits,
                COALESCE(wth.total_withdrawals, 0) AS total_withdrawals,
                COALESCE(dep.total_deposit_charges, 0) AS total_deposit_charges,
                COALESCE(wth.total_withdrawal_charges, 0) AS total_withdrawal_charges,
                (COALESCE(dep.total_deposit_charges, 0) + COALESCE(wth.total_withdrawal_charges, 0)) AS total_charges,
                (COALESCE(dep.deposit_count, 0) + COALESCE(wth.withdrawal_count, 0)) AS transaction_count
            FROM customers c
            LEFT JOIN (
                SELECT 
                    customer_id,
                    SUM(amount) AS total_deposits,
                    SUM(charges) AS total_deposit_charges,
                    COUNT(*) AS deposit_count
                FROM deposits
                WHERE customer_id = :dep_id
                GROUP BY customer_id
            ) dep ON dep.customer_id = c.id
            LEFT JOIN (
                SELECT 
                    customer_id,
                    SUM(amount) AS total_withdrawals,
                    SUM(charges) AS total_withdrawal_charges,
                    COUNT(*) AS withdrawal_count
                FROM withdrawals
                WHERE customer_id = :wth_id
                GROUP BY customer_id
            ) wth ON wth.customer_id = c.id
            WHERE c.id = :id
            LIMIT 1
        ");

        $stmt->execute([
            ':id'     => $id,
            ':dep_id' => $id,
            ':wth_id' => $id,
        ]);

        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        return $customer ?: null;
    }

    /**
     * Find customer by ID.
     */
    public function find(int $id): ?array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM customers
            WHERE id = :id
            LIMIT 1
        ");

        $stmt->execute([':id' => $id]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        return $customer ?: null;
    }

    /**
     * Find customer by customer code.
     */
    public function findByCode(string $code): ?array
    {
        $stmt = $this->db->prepare("
            SELECT *
            FROM customers
            WHERE customer_code = :code
            LIMIT 1
        ");

        $stmt->execute([':code' => trim($code)]);
        $customer = $stmt->fetch(PDO::FETCH_ASSOC);

        return $customer ?: null;
    }

    /**
     * Search customers.
     */
    public function search(string $keyword): array
    {
        $keyword = trim($keyword);

        $stmt = $this->db->prepare("
            SELECT *
            FROM customers
            WHERE
                fullname LIKE :keyword
                OR phone LIKE :keyword
                OR email LIKE :keyword
                OR customer_code LIKE :keyword
            ORDER BY fullname ASC
        ");

        $stmt->execute([':keyword' => '%' . $keyword . '%']);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Check whether an email already exists.
     */
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $sql = "SELECT id FROM customers WHERE email = :email";
        $params = [':email' => trim($email)];

        if ($excludeId !== null) {
            $sql .= " AND id != :exclude_id";
            $params[':exclude_id'] = $excludeId;
        }

        $sql .= " LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (bool) $stmt->fetchColumn();
    }

    /**
     * Check whether a phone number already exists.
     */
    public function phoneExists(string $phone, ?int $excludeId = null): bool
    {
        $sql = "SELECT id FROM customers WHERE phone = :phone";
        $params = [':phone' => trim($phone)];

        if ($excludeId !== null) {
            $sql .= " AND id != :exclude_id";
            $params[':exclude_id'] = $excludeId;
        }

        $sql .= " LIMIT 1";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);

        return (bool) $stmt->fetchColumn();
    }

    /**
     * Create customer.
     */
    public function create(array $data): bool
    {
        $stmt = $this->db->prepare("
            INSERT INTO customers
            (
                customer_code,
                fullname,
                gender,
                phone,
                email,
                address,
                occupation,
                picture,
                status,
                created_by
            )
            VALUES
            (
                :customer_code,
                :fullname,
                :gender,
                :phone,
                :email,
                :address,
                :occupation,
                :picture,
                :status,
                :created_by
            )
        ");

        return $stmt->execute([
            ':customer_code' => $data['customer_code'],
            ':fullname'      => $data['fullname'],
            ':gender'        => $data['gender'],
            ':phone'         => $data['phone'],
            ':email'         => $data['email'] ?? null,
            ':address'       => $data['address'] ?? null,
            ':occupation'    => $data['occupation'] ?? null,
            ':picture'       => $data['picture'] ?? null,
            ':status'        => $data['status'] ?? 'Active',
            ':created_by'    => $data['created_by']
        ]);
    }

    /**
     * Update customer.
     */
    public function update(int $id, array $data): bool
    {
        $stmt = $this->db->prepare("
            UPDATE customers
            SET
                fullname = :fullname,
                gender = :gender,
                phone = :phone,
                email = :email,
                address = :address,
                occupation = :occupation,
                picture = :picture,
                status = :status,
                updated_by = :updated_by,
                updated_at = NOW()
            WHERE id = :id
        ");

        return $stmt->execute([
            ':id'         => $id,
            ':fullname'   => $data['fullname'],
            ':gender'     => $data['gender'],
            ':phone'      => $data['phone'],
            ':email'      => $data['email'] ?? null,
            ':address'    => $data['address'] ?? null,
            ':occupation' => $data['occupation'] ?? null,
            ':picture'    => $data['picture'] ?? null,
            ':status'     => $data['status'] ?? 'Active',
            ':updated_by' => $data['updated_by']
        ]);
    }

    /**
     * Delete customer.
     */
    public function delete(int $id): bool
    {
        $stmt = $this->db->prepare("DELETE FROM customers WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Count customers.
     */
    public function count(): int
    {
        $stmt = $this->db->query("SELECT COUNT(*) FROM customers");
        return (int) $stmt->fetchColumn();
    }

    /**
     * Generate customer code.
     */
    public function generateCode(): string
    {
        $lastId = (int) $this->db
            ->query("SELECT COALESCE(MAX(id), 0) FROM customers")
            ->fetchColumn();

        return 'CUS' . str_pad((string) ($lastId + 1), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Get total deposits for a customer.
     */
    public function totalDeposits(int $id): float
    {
        $stmt = $this->db->prepare("
            SELECT COALESCE(SUM(amount), 0)
            FROM deposits
            WHERE customer_id = :customer_id
        ");
        $stmt->execute([':customer_id' => $id]);

        return (float) $stmt->fetchColumn();
    }

    /**
     * Get total withdrawals for a customer.
     */
    public function totalWithdrawals(int $id): float
    {
        $stmt = $this->db->prepare("
            SELECT COALESCE(SUM(amount), 0)
            FROM withdrawals
            WHERE customer_id = :customer_id
        ");
        $stmt->execute([':customer_id' => $id]);

        return (float) $stmt->fetchColumn();
    }

    /**
     * Get total deposit charges.
     */
    public function totalDepositCharges(int $id): float
    {
        $stmt = $this->db->prepare("
            SELECT COALESCE(SUM(charges), 0)
            FROM deposits
            WHERE customer_id = :customer_id
        ");
        $stmt->execute([':customer_id' => $id]);

        return (float) $stmt->fetchColumn();
    }

    /**
     * Get total withdrawal charges.
     */
    public function totalWithdrawalCharges(int $id): float
    {
        $stmt = $this->db->prepare("
            SELECT COALESCE(SUM(charges), 0)
            FROM withdrawals
            WHERE customer_id = :customer_id
        ");
        $stmt->execute([':customer_id' => $id]);

        return (float) $stmt->fetchColumn();
    }

    /**
     * Get total combined charges.
     */
    public function totalCharges(int $id): float
    {
        return $this->totalDepositCharges($id) + $this->totalWithdrawalCharges($id);
    }

    /**
     * Get total number of transactions.
     */
    public function transactionCount(int $id): int
    {
        $stmt = $this->db->prepare("
            SELECT
                (SELECT COUNT(*) FROM deposits WHERE customer_id = :dep_id)
                +
                (SELECT COUNT(*) FROM withdrawals WHERE customer_id = :wth_id)
        ");

        $stmt->execute([
            ':dep_id' => $id,
            ':wth_id' => $id
        ]);

        return (int) $stmt->fetchColumn();
    }
}