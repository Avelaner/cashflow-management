<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title><?= htmlspecialchars($title ?? 'Cashflow Management') ?></title>

 <!-- Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

<!-- Google Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Global CSS -->
<link rel="stylesheet" href="<?= asset('css/style.css') ?>">
<link rel="stylesheet" href="<?= asset('css/components.css') ?>">
<link rel="stylesheet" href="<?= asset('css/responsive.css') ?>">
<link
    rel="stylesheet"
    href="<?= asset('css/withdrawals.css') ?>">

    <link
    rel="stylesheet"
    href="<?= asset(
        'css/expenses.css'
    ) ?>"
>

<?php

$page = strtolower($title ?? '');

?>

<?php if ($page === 'dashboard'): ?>

    <link rel="stylesheet"
          href="<?= asset('css/dashboard.css') ?>">

<?php endif; ?>

<?php if (strtolower($title ?? '') === 'items'): ?>
    <link rel="stylesheet" href="<?= asset('css/items.css') ?>">
<?php endif; ?>

<?php if (
    strtolower($title ?? '') === 'deposits / transfer'
): ?>

    <link
        rel="stylesheet"
        href="<?= asset('css/deposits.css') ?>">

<?php endif; ?>


<?php if (
    $page === 'customers' ||
    $page === 'add customer' ||
    $page === 'edit customer' ||
    $page === 'customer profile'
): ?>

    <link rel="stylesheet"
          href="<?= asset('css/customers.css') ?>">

<?php endif; ?>


<?php if ($page === 'login'): ?>

    <link rel="stylesheet"
          href="<?= asset('css/auth.css') ?>">

<?php endif; ?>


<?php if ($page === 'home'): ?>

    <link rel="stylesheet"
          href="<?= asset('css/landing.css') ?>">

<?php endif; ?>



</head>

<body>