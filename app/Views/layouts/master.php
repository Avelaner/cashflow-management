<?php require BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="wrapper">

    <?php require BASE_PATH . '/app/Views/layouts/sidebar.php'; ?>

    <div class="main">

        <?php require BASE_PATH . '/app/Views/layouts/navbar.php'; ?>

        <main class="content">

            <?= $content ?>

        </main>

        <?php require BASE_PATH . '/app/Views/layouts/footer.php'; ?>

    </div>

</div>