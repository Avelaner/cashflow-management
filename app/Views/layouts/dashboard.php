<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title ?? 'Dashboard') ?></title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- CSS -->
    <link rel="stylesheet" href="<?= asset('css/app.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/components.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/dashboard.css') ?>">
    <link rel="stylesheet" href="<?= asset('css/responsive.css') ?>">

</head>

<body>
    <div id="sidebarOverlay"></div>

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

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($cashflow)) : ?>

<script>

window.cashflowData = <?= json_encode($cashflow) ?>;

</script>

<?php endif; ?>

<!-- Dashboard JS -->
<script src="<?= asset('js/dashboard.js') ?>"></script>

<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

</body>

</html>