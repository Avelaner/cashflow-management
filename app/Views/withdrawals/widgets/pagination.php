<?php if ($totalPages > 1): ?>

    <div class="card-footer bg-white">

        <nav aria-label="Withdrawal pagination">

            <ul class="pagination justify-content-center mb-0">

                <!-- Previous -->
                <li
                    class="page-item
                    <?= $page <= 1
                        ? 'disabled'
                        : '' ?>">

                    <a
                        class="page-link"
                        href="<?= $page > 1
                            ? base_url(
                                'withdrawals?page='
                                . ($page - 1)
                                . '&search='
                                . urlencode(
                                    $search ?? ''
                                )
                            )
                            : '#' ?>">

                        <i class="fas fa-chevron-left"></i>

                        Previous

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
                                'withdrawals?page='
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
                        href="<?= $page < $totalPages
                            ? base_url(
                                'withdrawals?page='
                                . ($page + 1)
                                . '&search='
                                . urlencode(
                                    $search ?? ''
                                )
                            )
                            : '#' ?>">

                        Next

                        <i class="fas fa-chevron-right"></i>

                    </a>

                </li>

            </ul>

        </nav>

    </div>

<?php endif; ?>