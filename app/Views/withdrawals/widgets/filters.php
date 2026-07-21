<form
    method="GET"
    action="<?= base_url('withdrawals') ?>"
    class="card withdrawal-filter-card mb-4">

    <div class="card-body">

        <div class="row g-3 align-items-end">

            <!-- Search -->
            <div class="col-lg-9">

                <label class="form-label fw-semibold">

                    Search Withdrawals

                </label>

                <div class="input-group">

                    <span class="input-group-text">

                        <i class="fas fa-search"></i>

                    </span>

                    <input
                        type="search"
                        name="search"
                        class="form-control"
                        placeholder="Search customer, code, account, bank or description..."
                        value="<?= htmlspecialchars(
                            $search ?? ''
                        ) ?>">

                </div>

            </div>


            <!-- Search Button -->
            <div class="col-lg-3">

                <div class="d-flex gap-2">

                    <button
                        type="submit"
                        class="btn btn-primary flex-grow-1">

                        <i class="fas fa-search me-2"></i>

                        Search

                    </button>


                    <?php if (
                        !empty($search)
                    ): ?>

                        <a
                            href="<?= base_url(
                                'withdrawals'
                            ) ?>"
                            class="btn btn-outline-secondary">

                            <i class="fas fa-xmark"></i>

                        </a>

                    <?php endif; ?>

                </div>

            </div>

        </div>

    </div>

</form>