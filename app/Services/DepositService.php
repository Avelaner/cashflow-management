<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Deposit;

class DepositService
{
    private Deposit $deposit;


    public function __construct()
    {
        $this->deposit = new Deposit();
    }


    /**
     * Get all deposits.
     */
    public function all(): array
    {
        return $this->deposit->all();
    }


    /**
     * Get deposit by ID.
     */
    public function find(int $id): ?array
    {
        return $this->deposit->find($id);
    }


    /**
     * Create deposit.
     */
    public function create(array $data): bool
    {
        $user = Auth::user();

        $data['created_by'] =
            $user['id'];

        return $this->deposit->create($data);
    }


    /**
     * Update deposit.
     */
   public function update(
    int $id,
    array $data
): bool {

    return $this->deposit
        ->update(
            $id,
            $data
        );
}


    /**
     * Delete deposit.
     */
    public function delete(int $id): bool
    {
        return $this->deposit->delete($id);
    }


    /**
     * Get paginated deposits.
     */
    public function paginate(
        int $page = 1,
        int $perPage = 10,
        string $search = ''
    ): array {

        $page = max(1, $page);

        $offset =
            ($page - 1) * $perPage;


        $result =
            $this->deposit->paginate(
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
     * Deposit statistics.
     */
    public function stats(): array
    {
        return $this->deposit->stats();
    }


    /**
     * Total deposits for customer.
     */
    public function totalByCustomer(
        int $customerId
    ): float {

        return $this->deposit
            ->totalByCustomer($customerId);
    }


    /**
     * Count deposits.
     */
    public function count(): int
    {
        return $this->deposit->count();
    }
}