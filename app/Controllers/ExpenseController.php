<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Authorization;
use App\Core\Controller;
use App\Services\ExpenseService;
use InvalidArgumentException;

class ExpenseController extends Controller
{
    private ExpenseService $expenseService;

    /**
     * Expense controller constructor.
     */
    public function __construct()
    {
        $this->expenseService = new ExpenseService();
    }

    /**
     * Display all expenses.
     */
    public function index(): void
    {
        Authorization::authorize('expenses.view');

        // Get Filters
        $filters = [
            'search'         => trim((string) ($_GET['search'] ?? '')),
            'category'       => trim((string) ($_GET['category'] ?? '')),
            'payment_method' => trim((string) ($_GET['payment_method'] ?? '')),
            'date_from'      => trim((string) ($_GET['date_from'] ?? '')),
            'date_to'        => trim((string) ($_GET['date_to'] ?? '')),
        ];

        // Get Filtered Expenses & Summary Stats
        $expenses           = $this->expenseService->getAllExpenses($filters);
        $totalExpenses      = $this->expenseService->getTotalExpenses();
        $todayTotalExpenses = $this->expenseService->getTodayTotalExpenses();

        // Load View via Core Controller
        $this->view('expenses/index', [
            'title'              => 'Expenses',
            'expenses'           => $expenses,
            'totalExpenses'      => $totalExpenses,
            'todayTotalExpenses' => $todayTotalExpenses,
            'filters'            => $filters,
        ]);
    }

    /**
     * Display create expense form.
     */
    public function create(): void
    {
        Authorization::authorize('expenses.create');

        $this->view('expenses/create', [
            'title' => 'Add Expense',
        ]);
    }

    /**
     * Store a new expense.
     */
    public function store(): void
    {
        Authorization::authorize('expenses.create');

        try {
            $data = $_POST;

            // Attach Logged-In User
            $data['created_by'] = $_SESSION['user']['id'] ?? null;

            // Create Expense
            $this->expenseService->createExpense($data);

            $_SESSION['success'] = 'Expense added successfully.';
            redirect('expenses');

        } catch (InvalidArgumentException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect('expenses/create');
        }
    }

    /**
     * Display a single expense.
     */
    public function show(int $id): void
    {
        Authorization::authorize('expenses.view');

        $expense = $this->expenseService->getExpense($id);

        if (!$expense) {
            $_SESSION['error'] = 'Expense not found.';
            redirect('expenses');
            return;
        }

        $this->view('expenses/show', [
            'title'   => 'View Expense',
            'expense' => $expense,
        ]);
    }

    /**
     * Display edit expense form.
     */
    public function edit(int $id): void
    {
        Authorization::authorize('expenses.edit');

        $expense = $this->expenseService->getExpense($id);

        if (!$expense) {
            $_SESSION['error'] = 'Expense not found.';
            redirect('expenses');
            return;
        }

        $this->view('expenses/edit', [
            'title'   => 'Edit Expense',
            'expense' => $expense,
        ]);
    }

    /**
     * Update an existing expense.
     */
    public function update(int $id): void
    {
        Authorization::authorize('expenses.edit');

        try {
            $this->expenseService->updateExpense($id, $_POST);

            $_SESSION['success'] = 'Expense updated successfully.';
            redirect('expenses/show/' . $id);

        } catch (InvalidArgumentException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect('expenses/edit/' . $id);
        }
    }

    /**
     * Delete an expense.
     */
    public function delete(int $id): void
    {
        Authorization::authorize('expenses.delete');

        try {
            $this->expenseService->deleteExpense($id);

            $_SESSION['success'] = 'Expense deleted successfully.';
            redirect('expenses');

        } catch (InvalidArgumentException $e) {
            $_SESSION['error'] = $e->getMessage();
            redirect('expenses');
        }
    }
}