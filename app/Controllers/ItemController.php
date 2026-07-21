<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Models\Item;
use App\Models\Customer;
use App\Models\Sale;
use App\Services\Auth;
use App\Services\PermissionService;
use Config\Database;
use Exception;

class ItemController
{
    /**
     * Helper to enforce permissions and handle unauthorized access.
     */
    private function checkPermission(string $permission): void
    {
        if (!PermissionService::can($permission)) {
            $_SESSION['flash_error'] = 'You do not have permission to perform this action.';
            header('Location: ' . base_url('dashboard'));
            exit;
        }
    }

    /**
     * Helper to enforce POST requests and check CSRF token.
     */
    private function checkPostRequest(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $_SESSION['flash_error'] = 'Invalid request method.';
            header('Location: ' . base_url('items'));
            exit;
        }

        $token = $_POST['csrf_token'] ?? '';
        $sessionToken = $_SESSION['csrf_token'] ?? '';

        if (empty($token) || empty($sessionToken) || !hash_equals($sessionToken, $token)) {
            $_SESSION['flash_error'] = 'Invalid security token. Please try again.';
            header('Location: ' . base_url('items'));
            exit;
        }
    }

    /**
     * Extract and sanitize common item post payload.
     */
    private function extractItemData(): array
    {
        return [
            'name'            => trim($_POST['name'] ?? ''),
            'brand'           => trim($_POST['brand'] ?? ''),
            'description'     => trim($_POST['description'] ?? ''),
            'buying_price'    => (float) ($_POST['buying_price'] ?? 0),
            'selling_price'   => (float) ($_POST['selling_price'] ?? 0),
            'quantity'        => (int) ($_POST['quantity'] ?? 0),
            'min_stock_alert' => (int) ($_POST['min_stock_alert'] ?? 5),
        ];
    }

    public function index(): void
    {
        $this->checkPermission('items.view');

        // Ensure session CSRF token exists
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }

        $csrfToken = $_SESSION['csrf_token'];
        $items     = Item::getAll();
        $customers = (new Customer())->all();
        
        // FETCH SALES LIST WITH JOIN DETAILS
        $sales = Sale::getAllWithDetails();

        require_once dirname(__DIR__, 2) . '/app/Views/items/index.php';
    }

    public function store(): void
    {
        $this->checkPermission('items.create');
        $this->checkPostRequest();

        $data = $this->extractItemData();

        if (empty($data['name']) || $data['selling_price'] <= 0) {
            $_SESSION['flash_error'] = 'Item name and a valid selling price are required.';
            header('Location: ' . base_url('items'));
            exit;
        }

        if (Item::create($data)) {
            $_SESSION['flash_success'] = 'Item created successfully!';
        } else {
            $_SESSION['flash_error'] = 'Failed to create item.';
        }

        header('Location: ' . base_url('items'));
        exit;
    }

    public function update(int $id): void
    {
        $this->checkPermission('items.edit');
        $this->checkPostRequest();

        $data = $this->extractItemData();

        if (empty($data['name']) || $data['selling_price'] <= 0) {
            $_SESSION['flash_error'] = 'Item name and a valid selling price are required.';
            header('Location: ' . base_url('items'));
            exit;
        }

        if (Item::update($id, $data)) {
            $_SESSION['flash_success'] = 'Item updated successfully!';
        } else {
            $_SESSION['flash_error'] = 'Failed to update item.';
        }

        header('Location: ' . base_url('items'));
        exit;
    }

    public function sell(int $id): void
    {
        $this->checkPostRequest();

        $userId = Auth::id();

        if (!$userId) {
            $_SESSION['flash_error'] = 'Please log in to perform this action.';
            header('Location: ' . base_url('login'));
            exit;
        }

        $qty = (int) ($_POST['sell_quantity'] ?? 1);
        $customerIdInput = $_POST['customer_id'] ?? 'walk_in';

        $item = Item::find($id);

        if (!$item) {
            $_SESSION['flash_error'] = 'Item not found.';
            header('Location: ' . base_url('items'));
            exit;
        }

        if ($qty <= 0 || $qty > (int)$item['quantity']) {
            $_SESSION['flash_error'] = 'Invalid quantity or insufficient stock available.';
            header('Location: ' . base_url('items'));
            exit;
        }

        $finalCustomerId = null;
        $customerModel = new Customer();

        // 1. Handle Customer Registration or Selection
        if ($customerIdInput === 'walk_in') {
            $fullname = trim($_POST['fullname'] ?? '');
            $phone    = trim($_POST['phone'] ?? '');

            if (empty($fullname) || empty($phone)) {
                $_SESSION['flash_error'] = 'Customer Full Name and Phone Number are required.';
                header('Location: ' . base_url('items'));
                exit;
            }

            $code = $customerModel->generateCode();
            $created = $customerModel->create([
                'customer_code' => $code,
                'fullname'      => $fullname,
                'gender'        => $_POST['gender'] ?? 'Male',
                'phone'         => $phone,
                'email'         => trim($_POST['email'] ?? ''),
                'address'       => trim($_POST['address'] ?? ''),
                'occupation'    => trim($_POST['occupation'] ?? ''),
                'status'        => 'Active',
                'created_by'    => $userId,
            ]);

            if ($created) {
                // Fetch newly inserted customer ID securely
                $newCustomer = $customerModel->findByCode($code);
                $finalCustomerId = !empty($newCustomer['id']) ? (int)$newCustomer['id'] : null;
            } else {
                $_SESSION['flash_error'] = 'Failed to register customer profile.';
                header('Location: ' . base_url('items'));
                exit;
            }
        } else {
            $finalCustomerId = (int) $customerIdInput;
        }

        // 2. Unit Price Calculation
        $unitPrice = (float) ($item['selling_price'] ?? $item['unit_price'] ?? $item['price'] ?? 0.00);
        $totalAmount = $unitPrice * $qty;

        // 3. Database Transaction atomic execution
        $db = Database::connect();
        try {
            $db->beginTransaction();

            if (!Item::sell($id, $qty)) {
                throw new Exception('Failed to update stock quantity.');
            }

            $logged = Sale::create([
                'item_id'      => $id,
                'customer_id'  => $finalCustomerId,
                'sold_by'      => $userId,
                'quantity'     => $qty,
                'unit_price'   => $unitPrice,
                'total_amount' => $totalAmount,
            ]);

            if (!$logged) {
                throw new Exception('Failed to record transaction log.');
            }

            $db->commit();
            $_SESSION['flash_success'] = "Successfully sold {$qty} unit(s) of " . htmlspecialchars($item['name']) . ".";
        } catch (Exception $e) {
            if ($db->inTransaction()) {
                $db->rollBack();
            }
            $_SESSION['flash_error'] = 'Transaction failed: ' . $e->getMessage();
        }

        header('Location: ' . base_url('items'));
        exit;
    }

    public function destroy(int $id): void
    {
        $this->checkPermission('items.delete');
        $this->checkPostRequest();

        if (Item::delete($id)) {
            $_SESSION['flash_success'] = 'Item removed from inventory.';
        } else {
            $_SESSION['flash_error'] = 'Failed to delete item.';
        }

        header('Location: ' . base_url('items'));
        exit;
    }
}