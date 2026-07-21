<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Withdrawal;
use App\Core\Auth;

class WithdrawalService
{
    private Withdrawal $withdrawal;


    public function __construct()
    {
        $this->withdrawal =
            new Withdrawal();
    }


    /**
     * Get all withdrawals.
     */
    public function all(): array
    {
        return $this->withdrawal->all();
    }


    /**
     * Get withdrawal by ID.
     */
    public function find(int $id): ?array
    {
        return $this->withdrawal->find($id);
    }


    /**
     * Create withdrawal.
     */
   public function create(array $data): bool
{
    $userId = $_SESSION['user']['id'] ?? null;

    if (!$userId) {
        throw new RuntimeException(
            'User is not authenticated.'
        );
    }

    $data['created_by'] = $userId;

    return $this->withdrawal
        ->create($data);
}


    /**
     * Update withdrawal.
     */
    public function update(
        int $id,
        array $data
    ): bool {

        return $this->withdrawal
            ->update(
                $id,
                $data
            );
    }


    /**
     * Delete withdrawal.
     */
    public function delete(int $id): bool
    {
        return $this->withdrawal
            ->delete($id);
    }


    /**
     * Get paginated withdrawals.
     */
    public function paginate(
        int $page = 1,
        int $perPage = 10,
        string $search = ''
    ): array {

        $page =
            max(1, $page);

        $offset =
            ($page - 1)
            * $perPage;


        $result =
            $this->withdrawal
                ->paginate(
                    $perPage,
                    $offset,
                    trim($search)
                );


        $totalPages =
            $result['total'] > 0

            ? (int) ceil(
                $result['total']
                / $perPage
            )

            : 1;


        return [

            'data' =>
                $result['data'],

            'total' =>
                $result['total'],

            'page' =>
                $page,

            'perPage' =>
                $perPage,

            'totalPages' =>
                $totalPages

        ];
    }


    /**
     * Get withdrawal statistics.
     */
    public function stats(): array
    {
        return $this->withdrawal
            ->stats();
    }


    /**
     * Total withdrawals for customer.
     */
    public function totalByCustomer(
        int $customerId
    ): float {

        return $this->withdrawal
            ->totalByCustomer(
                $customerId
            );
    }


    /**
     * Count withdrawals.
     */
    public function count(): int
    {
        return $this->withdrawal
            ->count();
    }
}