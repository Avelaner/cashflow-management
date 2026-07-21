<?php 
$title = 'Items';

// 1. Load Header
require_once __DIR__ . '/../layouts/header.php'; 

// 2. Load Sidebar
if (file_exists(__DIR__ . '/../layouts/sidebar.php')) {
    require_once __DIR__ . '/../layouts/sidebar.php';
}

// CSRF Token Helper
$csrfToken = $_SESSION['csrf_token'] ?? '';
?>

<style>
    /* Responsive adjustment for main content when sidebar collapses */
    .main-content {
        transition: all 0.3s ease;
        margin-left: 260px;
    }
    @media (max-width: 991.98px) {
        .main-content {
            margin-left: 0 !important;
        }
    }
    /* Touch target optimization for mobile tables */
    @media (max-width: 575.98px) {
        .action-btns .btn {
            width: 100%;
            margin-bottom: 0.35rem;
        }
    }
</style>

<div class="main-content">

    <!-- 3. Top Navbar -->
    <?php 
    $navbarPaths = [
        __DIR__ . '/../layouts/topbar.php',
        __DIR__ . '/../layouts/navbar.php',
        __DIR__ . '/../layouts/header-nav.php',
        __DIR__ . '/../layouts/nav.php'
    ];
    foreach ($navbarPaths as $path) {
        if (file_exists($path)) {
            require_once $path;
            break;
        }
    }
    ?>

    <div class="container-fluid px-3 px-md-4 py-3 py-md-4">

        <!-- Flash Alert Messages -->
        <?php if (!empty($_SESSION['flash_success'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-1"></i> <?= htmlspecialchars($_SESSION['flash_success']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash_success']); ?>
        <?php endif; ?>

        <?php if (!empty($_SESSION['flash_error'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-1"></i> <?= htmlspecialchars($_SESSION['flash_error']); ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
            <?php unset($_SESSION['flash_error']); ?>
        <?php endif; ?>

        <!-- Header Section -->
        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-3 mb-4">
            <div>
                <h4 class="fw-bold mb-1">Items & Inventory</h4>
                <small class="text-muted">Manage stock, prices, sales, and inventory alerts</small>
            </div>
            <div>
                <button class="btn btn-primary w-100 w-sm-auto" data-bs-toggle="modal" data-bs-target="#addItemModal">
                    <i class="fas fa-plus me-1"></i> Add New Item
                </button>
            </div>
        </div>

        <!-- Summary KPI Cards -->
        <div class="row g-2 g-md-3 mb-4">
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <small class="text-muted fw-semibold d-block text-truncate">Total Items</small>
                        <h5 class="mb-0 fw-bold mt-1"><?= count($items ?? []); ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <small class="text-muted fw-semibold d-block text-truncate">In Stock</small>
                        <h5 class="mb-0 fw-bold mt-1"><?= array_sum(array_column($items ?? [], 'quantity')); ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-4 col-xl-2">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <small class="text-muted fw-semibold d-block text-truncate">Items Sold</small>
                        <h5 class="mb-0 fw-bold mt-1"><?= array_sum(array_column($items ?? [], 'quantity_sold')); ?></h5>
                    </div>
                </div>
            </div>
            <div class="col-6 col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <small class="text-muted fw-semibold d-block text-truncate">Total Cost</small>
                        <h5 class="mb-0 fw-bold mt-1">
                            ₦<?= number_format(array_reduce($items ?? [], function($carry, $item) {
                                return $carry + ($item['buying_price'] * $item['quantity']);
                            }, 0), 2); ?>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-body p-3">
                        <small class="text-muted fw-semibold d-block text-truncate">Stock Value</small>
                        <h5 class="mb-0 fw-bold mt-1">
                            ₦<?= number_format(array_reduce($items ?? [], function($carry, $item) {
                                return $carry + ($item['selling_price'] * $item['quantity']);
                            }, 0), 2); ?>
                        </h5>
                    </div>
                </div>
            </div>
        </div>

        <!-- ================= SECTION 1: INVENTORY ITEMS TABLE ================= -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-boxes me-2 text-primary"></i>Inventory Stock Table</h5>
                <span class="badge bg-primary rounded-pill"><?= count($items ?? []); ?> Items</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Item Name</th>
                                <th>Brand</th>
                                <th>Buying Price</th>
                                <th>Selling Price</th>
                                <th>Stock Status</th>
                                <th>Units Sold</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($items)): ?>
                                <tr>
                                    <td colspan="8" class="text-center py-4 text-muted">No items found in inventory.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($items as $index => $item): ?>
                                    <tr>
                                        <td><?= $index + 1; ?></td>
                                        <td>
                                            <span class="fw-bold d-block"><?= htmlspecialchars($item['name']); ?></span>
                                            <?php if (!empty($item['description'])): ?>
                                                <small class="text-muted d-block text-truncate" style="max-width: 200px;">
                                                    <?= htmlspecialchars($item['description']); ?>
                                                </small>
                                            <?php endif; ?>
                                        </td>
                                        <td><?= htmlspecialchars($item['brand'] ?? 'N/A'); ?></td>
                                        <td>₦<?= number_format((float)$item['buying_price'], 2); ?></td>
                                        <td class="fw-bold">₦<?= number_format((float)$item['selling_price'], 2); ?></td>
                                        <td>
                                            <span class="badge <?= htmlspecialchars($item['status']['badge'] ?? 'bg-secondary'); ?> me-1">
                                                <?= htmlspecialchars($item['status']['label'] ?? 'Unknown'); ?>
                                            </span>
                                            <small class="text-muted d-block d-sm-inline mt-1 mt-sm-0">(<?= (int)$item['quantity']; ?> remaining)</small>
                                        </td>
                                        <td><?= (int)($item['quantity_sold'] ?? 0); ?></td>
                                        <td class="text-end action-btns">
                                            <div class="d-flex flex-column flex-sm-row justify-content-end gap-1">
                                                <button class="btn btn-sm btn-success" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#sellItemModal<?= $item['id']; ?>"
                                                        <?= $item['quantity'] <= 0 ? 'disabled' : ''; ?>>
                                                    <i class="fas fa-shopping-cart"></i> <span class="d-sm-none">Sell</span>
                                                </button>
                                                <button class="btn btn-sm btn-outline-primary" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editItemModal<?= $item['id']; ?>">
                                                    <i class="fas fa-edit"></i> <span class="d-sm-none">Edit</span>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger" 
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#deleteItemModal<?= $item['id']; ?>">
                                                    <i class="fas fa-trash"></i> <span class="d-sm-none">Delete</span>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>

                                    <!-- SELL ITEM MODAL -->
                                    <div class="modal fade" id="sellItemModal<?= $item['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <form action="<?= base_url('items/sell/' . $item['id']); ?>" method="POST">
                                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken); ?>">
                                                    
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold">Record Sale - <?= htmlspecialchars($item['name']); ?></h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    
                                                    <div class="modal-body">
                                                        <div class="row g-2 mb-3">
                                                            <div class="col-6">
                                                                <label class="form-label text-muted small">Available Stock</label>
                                                                <input type="text" class="form-control bg-light" value="<?= (int)$item['quantity']; ?>" readonly>
                                                            </div>
                                                            <div class="col-6">
                                                                <label class="form-label text-muted small">Price / Unit</label>
                                                                <input type="text" class="form-control bg-light fw-bold" value="₦<?= number_format((float)$item['selling_price'], 2); ?>" readonly>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="sell_quantity_<?= $item['id']; ?>" class="form-label fw-semibold">Quantity to Sell *</label>
                                                            <input type="number" name="sell_quantity" id="sell_quantity_<?= $item['id']; ?>" class="form-control" min="1" max="<?= (int)$item['quantity']; ?>" value="1" required>
                                                        </div>

                                                        <hr class="my-3">

                                                        <div class="mb-3">
                                                            <label for="customer_select_<?= $item['id']; ?>" class="form-label fw-semibold">Customer Type / Selection *</label>
                                                            <select name="customer_id" id="customer_select_<?= $item['id']; ?>" class="form-select customer-type-select" data-item-id="<?= $item['id']; ?>" required>
                                                                <option value="walk_in" selected>+ New / Walk-in Customer (Register Details)</option>
                                                                <?php if (!empty($customers)): ?>
                                                                    <optgroup label="Existing Customers">
                                                                        <?php foreach ($customers as $customer): ?>
                                                                            <option value="<?= $customer['id']; ?>">
                                                                                <?= htmlspecialchars($customer['fullname']); ?> 
                                                                                <?= !empty($customer['phone']) && $customer['phone'] !== 'N/A' ? '(' . htmlspecialchars($customer['phone']) . ')' : ''; ?>
                                                                            </option>
                                                                        <?php endforeach; ?>
                                                                    </optgroup>
                                                                <?php endif; ?>
                                                            </select>
                                                        </div>

                                                        <div id="walk_in_fields_<?= $item['id']; ?>" class="border rounded p-3 bg-light mb-3">
                                                            <h6 class="fw-bold mb-3 text-primary"><i class="fas fa-user-plus me-1"></i> Walk-in Customer Profile</h6>
                                                            
                                                            <div class="mb-3">
                                                                <label class="form-label">Full Name *</label>
                                                                <input type="text" name="fullname" id="fullname_<?= $item['id']; ?>" class="form-control" placeholder="e.g. John Doe">
                                                            </div>

                                                            <div class="row g-2 mb-3">
                                                                <div class="col-12 col-md-6">
                                                                    <label class="form-label">Phone Number *</label>
                                                                    <input type="text" name="phone" id="phone_<?= $item['id']; ?>" class="form-control" placeholder="e.g. 08012345678">
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <label class="form-label">Gender *</label>
                                                                    <select name="gender" id="gender_<?= $item['id']; ?>" class="form-select">
                                                                        <option value="Male">Male</option>
                                                                        <option value="Female">Female</option>
                                                                        <option value="Other">Other</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="row g-2 mb-3">
                                                                <div class="col-12 col-md-6">
                                                                    <label class="form-label">Email Address</label>
                                                                    <input type="email" name="email" class="form-control" placeholder="john@example.com">
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <label class="form-label">Occupation</label>
                                                                    <input type="text" name="occupation" class="form-control" placeholder="e.g. Business Owner">
                                                                </div>
                                                            </div>

                                                            <div class="mb-0">
                                                                <label class="form-label">Residential / Business Address</label>
                                                                <textarea name="address" class="form-control" rows="2" placeholder="Full address details..."></textarea>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-success"><i class="fas fa-check me-1"></i> Confirm Sale</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- EDIT ITEM MODAL -->
                                    <div class="modal fade" id="editItemModal<?= $item['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                            <div class="modal-content">
                                                <form action="<?= base_url('items/update/' . $item['id']); ?>" method="POST">
                                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken); ?>">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold">Edit Item</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label class="form-label">Item Name *</label>
                                                            <input type="text" name="name" class="form-control" value="<?= htmlspecialchars($item['name']); ?>" required>
                                                        </div>
                                                        <div class="row g-2 mb-3">
                                                            <div class="col-12 col-md-6">
                                                                <label class="form-label">Brand</label>
                                                                <input type="text" name="brand" class="form-control" value="<?= htmlspecialchars($item['brand'] ?? ''); ?>">
                                                            </div>
                                                            <div class="col-12 col-md-6">
                                                                <label class="form-label">Min Stock Alert</label>
                                                                <input type="number" name="min_stock_alert" class="form-control" value="<?= (int)($item['min_stock_alert'] ?? 5); ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="row g-2 mb-3">
                                                            <div class="col-12 col-md-4">
                                                                <label class="form-label">Buying Price</label>
                                                                <input type="number" step="0.01" name="buying_price" class="form-control" value="<?= (float)$item['buying_price']; ?>" required>
                                                            </div>
                                                            <div class="col-12 col-md-4">
                                                                <label class="form-label">Selling Price *</label>
                                                                <input type="number" step="0.01" name="selling_price" class="form-control" value="<?= (float)$item['selling_price']; ?>" required>
                                                            </div>
                                                            <div class="col-12 col-md-4">
                                                                <label class="form-label">Stock Qty</label>
                                                                <input type="number" name="quantity" class="form-control" value="<?= (int)$item['quantity']; ?>" required>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label class="form-label">Description</label>
                                                            <textarea name="description" class="form-control" rows="2"><?= htmlspecialchars($item['description'] ?? ''); ?></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-primary">Update Item</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- DELETE ITEM MODAL -->
                                    <div class="modal fade" id="deleteItemModal<?= $item['id']; ?>" tabindex="-1">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <form action="<?= base_url('items/delete/' . $item['id']); ?>" method="POST">
                                                    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken); ?>">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title fw-bold text-danger">Confirm Deletion</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Are you sure you want to delete <strong><?= htmlspecialchars($item['name']); ?></strong> from inventory? This action cannot be undone.
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                                        <button type="submit" class="btn btn-danger">Delete Item</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <!-- ================= SECTION 2: SALES TRANSACTION TABLE ================= -->
<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-white py-3 border-0 d-flex justify-content-between align-items-center">
        <h5 class="fw-bold mb-0 text-dark"><i class="fas fa-receipt me-2 text-success"></i>Sales Transaction History</h5>
        <span class="badge bg-success rounded-pill"><?= count($sales ?? []); ?> Sales Recorded</span>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-dark">
                    <tr>
                        <th>#</th>
                        <th>Date & Time</th>
                        <th>Item</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Bought By (Customer)</th>
                        <th>Sold By (User)</th>
                        <th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($sales)): ?>
                        <?php foreach ($sales as $index => $sale): ?>
                            <?php 
                                $saleId = $sale['id'] ?? ($index + 1); 
                                // Fallback handling for date column naming
                                $saleDate = $sale['sold_at'] ?? $sale['created_at'] ?? null;
                                $formattedDate = $saleDate ? date('M d, Y - h:i A', strtotime($saleDate)) : 'N/A';
                                $modalDate = $saleDate ? date('F d, Y \a\t h:i A', strtotime($saleDate)) : 'N/A';
                            ?>
                            <tr>
                                <td><?= $index + 1; ?></td>
                                <td><?= $formattedDate; ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($sale['item_name'] ?? 'N/A'); ?></td>
                                <td><span class="badge bg-info text-dark"><?= (int)($sale['quantity'] ?? 0); ?></span></td>
                                <td class="fw-bold text-success">₦<?= number_format((float)($sale['total_amount'] ?? 0), 2); ?></td>
                                <td>
                                    <?= htmlspecialchars(!empty($sale['fullname']) ? $sale['fullname'] : 'Walk-in Customer'); ?>
                                    <?php if (!empty($sale['phone']) && $sale['phone'] !== 'N/A'): ?>
                                        <br><small class="text-muted"><?= htmlspecialchars($sale['phone']); ?></small>
                                    <?php endif; ?>
                                </td>
                                <td><span class="badge bg-secondary"><?= htmlspecialchars($sale['sold_by_user'] ?? $sale['cashier_name'] ?? 'System Admin'); ?></span></td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-outline-info" data-bs-toggle="modal" data-bs-target="#viewSaleModal<?= $saleId; ?>">
                                        <i class="fas fa-eye me-1"></i> View Details
                                    </button>
                                </td>
                            </tr>

                            <!-- VIEW SALE DETAILS MODAL -->
                            <div class="modal fade" id="viewSaleModal<?= $saleId; ?>" tabindex="-1">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title fw-bold">
                                                <i class="fas fa-file-invoice text-primary me-2"></i>Sale Details #<?= sprintf('%04d', $saleId); ?>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">
                                            <!-- Item & Transaction Info -->
                                            <div class="border-bottom pb-3 mb-3">
                                                <span class="text-muted small d-block mb-1">Transaction Information</span>
                                                <div class="d-flex justify-content-between align-items-center mb-1">
                                                    <strong class="fs-6"><?= htmlspecialchars($sale['item_name'] ?? 'N/A'); ?></strong>
                                                    <span class="badge bg-primary fs-6">₦<?= number_format((float)($sale['total_amount'] ?? 0), 2); ?></span>
                                                </div>
                                                <div class="row text-muted small mt-2">
                                                    <div class="col-6"><strong>Quantity:</strong> <?= (int)($sale['quantity'] ?? 0); ?> unit(s)</div>
                                                    <div class="col-6 text-end"><strong>Unit Price:</strong> ₦<?= number_format((float)($sale['unit_price'] ?? (($sale['total_amount'] ?? 0) / max(1, $sale['quantity'] ?? 1))), 2); ?></div>
                                                    <div class="col-12 mt-1"><strong>Date:</strong> <?= $modalDate; ?></div>
                                                    <div class="col-12 mt-1"><strong>Sold By:</strong> <?= htmlspecialchars($sale['sold_by_user'] ?? $sale['cashier_name'] ?? 'System Admin'); ?></div>
                                                </div>
                                            </div>

                                            <!-- Customer Information -->
                                            <div>
                                                <span class="text-muted small d-block mb-2">Customer Profile</span>
                                                <div class="bg-light rounded p-3">
                                                    <p class="mb-1">
                                                        <strong>Full Name:</strong> 
                                                        <?= htmlspecialchars(!empty($sale['fullname']) ? $sale['fullname'] : 'Walk-in Customer'); ?>
                                                    </p>
                                                    <p class="mb-1">
                                                        <strong>Phone:</strong> 
                                                        <?= htmlspecialchars(!empty($sale['phone']) ? $sale['phone'] : 'N/A'); ?>
                                                    </p>
                                                    <p class="mb-1">
                                                        <strong>Email:</strong> 
                                                        <?= htmlspecialchars(!empty($sale['email']) ? $sale['email'] : 'N/A'); ?>
                                                    </p>
                                                    <p class="mb-1">
                                                        <strong>Gender:</strong> 
                                                        <?= htmlspecialchars(!empty($sale['gender']) ? $sale['gender'] : 'N/A'); ?>
                                                    </p>
                                                    <p class="mb-1">
                                                        <strong>Occupation:</strong> 
                                                        <?= htmlspecialchars(!empty($sale['occupation']) ? $sale['occupation'] : 'N/A'); ?>
                                                    </p>
                                                    <p class="mb-0">
                                                        <strong>Address:</strong> 
                                                        <?= nl2br(htmlspecialchars(!empty($sale['address']) ? $sale['address'] : 'N/A')); ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center py-4 text-muted">No sales recorded yet.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

    </div>
</div>

<!-- ADD NEW ITEM MODAL -->
<div class="modal fade" id="addItemModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <form action="<?= base_url('items/store'); ?>" method="POST">
                <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrfToken); ?>">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Add New Inventory Item</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Item Name *</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Solar Inverter 3.5kVA" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-6">
                            <label class="form-label">Brand</label>
                            <input type="text" name="brand" class="form-control" placeholder="e.g. FelicitySolar">
                        </div>
                        <div class="col-12 col-md-6">
                            <label class="form-label">Min Stock Alert</label>
                            <input type="number" name="min_stock_alert" class="form-control" value="5" required>
                        </div>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-4">
                            <label class="form-label">Buying Price</label>
                            <input type="number" step="0.01" name="buying_price" class="form-control" placeholder="0.00" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">Selling Price *</label>
                            <input type="number" step="0.01" name="selling_price" class="form-control" placeholder="0.00" required>
                        </div>
                        <div class="col-12 col-md-4">
                            <label class="form-label">Stock Qty</label>
                            <input type="number" name="quantity" class="form-control" placeholder="0" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="2" placeholder="Item description details..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-plus me-1"></i> Save Item</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.customer-type-select').forEach(select => {
        select.addEventListener('change', function () {
            const itemId = this.getAttribute('data-item-id');
            const walkInFields = document.getElementById(`walk_in_fields_${itemId}`);
            
            if (this.value === 'walk_in') {
                walkInFields.style.display = 'block';
                // Enable required attributes for new walk-in details
                document.getElementById(`fullname_${itemId}`).required = true;
                document.getElementById(`phone_${itemId}`).required = true;
            } else {
                walkInFields.style.display = 'none';
                // Remove required attributes when selecting an existing customer
                document.getElementById(`fullname_${itemId}`).required = false;
                document.getElementById(`phone_${itemId}`).required = false;
            }
        });
    });
});
</script>
<?php 
// Load Footer if available
if (file_exists(__DIR__ . '/../layouts/footer.php')) {
    require_once __DIR__ . '/../layouts/footer.php';
}
?>