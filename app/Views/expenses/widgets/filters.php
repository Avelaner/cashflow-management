<?php

declare(strict_types=1);

?>

<!-- Expense Search and Filters -->

<div class="card expense-filter-card mb-4">

    <div class="card-body">

        <form
            action="<?= base_url('expenses') ?>"
            method="GET"
            class="row g-3 align-items-end"
        >

            <!-- Search -->

            <div class="col-lg-4 col-md-6">

                <label
                    for="search"
                    class="form-label"
                >

                    <i class="fas fa-search me-1"></i>

                    Search Expenses

                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="fas fa-search"></i>

                    </span>

                    <input
                        type="text"
                        name="search"
                        id="search"
                        class="form-control"
                        placeholder="Search category, description..."
                        value="<?= htmlspecialchars(
                            $_GET['search'] ?? ''
                        ) ?>"
                    >

                </div>

            </div>


            <!-- Category -->

            <div class="col-lg-2 col-md-6">

                <label
                    for="category"
                    class="form-label"
                >

                    <i class="fas fa-tag me-1"></i>

                    Category

                </label>

                <select
                    name="category"
                    id="category"
                    class="form-select"
                >

                    <option value="">
                        All Categories
                    </option>

                    <?php

                    $categories = [

                        'Rent',

                        'Salary',

                        'Utilities',

                        'Transportation',

                        'Office Supplies',

                        'Maintenance',

                        'Marketing',

                        'Other',

                    ];

                    ?>

                    <?php foreach (
                        $categories
                        as $category
                    ): ?>

                        <option
                            value="<?= htmlspecialchars(
                                $category
                            ) ?>"
                            <?= (
                                ($_GET[
                                    'category'
                                ] ?? '')
                                === $category
                            )
                                ? 'selected'
                                : ''
                            ?>
                        >

                            <?= htmlspecialchars(
                                $category
                            ) ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <!-- Payment Method -->

            <div class="col-lg-2 col-md-6">

                <label
                    for="payment_method"
                    class="form-label"
                >

                    <i class="fas fa-credit-card me-1"></i>

                    Payment Method

                </label>

                <select
                    name="payment_method"
                    id="payment_method"
                    class="form-select"
                >

                    <option value="">
                        All Methods
                    </option>

                    <?php

                    $paymentMethods = [

                        'Cash',

                        'Bank Transfer',

                        'POS',

                        'Card',

                        'Other',

                    ];

                    ?>

                    <?php foreach (
                        $paymentMethods
                        as $method
                    ): ?>

                        <option
                            value="<?= htmlspecialchars(
                                $method
                            ) ?>"
                            <?= (
                                ($_GET[
                                    'payment_method'
                                ] ?? '')
                                === $method
                            )
                                ? 'selected'
                                : ''
                            ?>
                        >

                            <?= htmlspecialchars(
                                $method
                            ) ?>

                        </option>

                    <?php endforeach; ?>

                </select>

            </div>


            <!-- Date From -->

            <div class="col-lg-2 col-md-6">

                <label
                    for="date_from"
                    class="form-label"
                >

                    <i class="far fa-calendar me-1"></i>

                    From

                </label>

                <input
                    type="date"
                    name="date_from"
                    id="date_from"
                    class="form-control"
                    value="<?= htmlspecialchars(
                        $_GET['date_from'] ?? ''
                    ) ?>"
                >

            </div>


            <!-- Date To -->

            <div class="col-lg-2 col-md-6">

                <label
                    for="date_to"
                    class="form-label"
                >

                    <i class="far fa-calendar me-1"></i>

                    To

                </label>

                <input
                    type="date"
                    name="date_to"
                    id="date_to"
                    class="form-control"
                    value="<?= htmlspecialchars(
                        $_GET['date_to'] ?? ''
                    ) ?>"
                >

            </div>


            <!-- Buttons -->

            <div class="col-12">

                <div
                    class="d-flex
                    justify-content-end
                    gap-2"
                >

                    <a
                        href="<?= base_url(
                            'expenses'
                        ) ?>"
                        class="btn
                        btn-outline-secondary"
                    >

                        <i
                            class="fas
                            fa-rotate-left
                            me-2"
                        ></i>

                        Reset

                    </a>


                    <button
                        type="submit"
                        class="btn btn-primary"
                    >

                        <i
                            class="fas
                            fa-filter
                            me-2"
                        ></i>

                        Apply Filters

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>