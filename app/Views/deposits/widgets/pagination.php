<?php if (($totalPages ?? 1) > 1): ?>

    <div class="deposit-pagination">

        <div class="pagination-info">

            Showing

            <strong>
                <?= (($page - 1) * $perPage) + 1 ?>
            </strong>

            to

            <strong>
                <?= min(
                    $page * $perPage,
                    $total
                ) ?>
            </strong>

            of

            <strong>
                <?= number_format($total) ?>
            </strong>

            deposits

        </div>


        <nav aria-label="Deposits pagination">

            <ul class="pagination mb-0">

                <!-- Previous -->
                <li
                    class="page-item
                    <?= $page <= 1 ? 'disabled' : '' ?>">

                    <a
                        class="page-link"
                        href="<?= base_url(
                            'deposits?page='
                            . ($page - 1)
                            . '&search='
                            . urlencode($search ?? '')
                        ) ?>">

                        <i class="fas fa-chevron-left"></i>

                        <span class="d-none d-md-inline ms-1">
                            Previous
                        </span>

                    </a>

                </li>


                <?php for (
                    $i = 1;
                    $i <= $totalPages;
                    $i++
                ): ?>

                    <li
                        class="page-item
                        <?= $i === $page
                            ? 'active'
                            : '' ?>">

                        <a
                            class="page-link"
                            href="<?= base_url(
                                'deposits?page='
                                . $i
                                . '&search='
                                . urlencode(
                                    $search ?? ''
                                )
                            ) ?>">

                            <?= $i ?>

                        </a>

                    </li>

                <?php endfor; ?>


                <!-- Next -->
                <li
                    class="page-item
                    <?= $page >= $totalPages
                        ? 'disabled'
                        : '' ?>">

                    <a
                        class="page-link"
                        href="<?= base_url(
                            'deposits?page='
                            . ($page + 1)
                            . '&search='
                            . urlencode($search ?? '')
                        ) ?>">

                        <span class="d-none d-md-inline me-1">
                            Next
                        </span>

                        <i class="fas fa-chevron-right"></i>

                    </a>

                </li>

            </ul>

        </nav>

    </div>

<?php endif; ?>