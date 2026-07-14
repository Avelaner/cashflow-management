<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">

<meta name="viewport"
content="width=device-width, initial-scale=1.0">

<title><?= htmlspecialchars($title) ?></title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">

<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" rel="stylesheet">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

body{
    font-family:Poppins,sans-serif;
    background:#f5f7fb;
    padding-top:80px;
}

/* ==========================
   NAVBAR
========================== */

.navbar{
    background:#0B1F3A;
    transition:all .35s ease;
    padding:15px 0;
}

.navbar.scrolled{
    background:#08182f;
    box-shadow:0 5px 20px rgba(0,0,0,.15);
}

.navbar-brand{
    font-size:1.4rem;
    font-weight:700;
}

.nav-link{
    color:#fff !important;
    margin-left:15px;
    transition:.3s;
}

.nav-link:hover{
    color:#6ea8fe !important;
}

.hero{
    padding:80px 0;
}

.hero h1{
    font-size:55px;
    font-weight:700;
    color:#0B1F3A;
}

.hero p{
    font-size:18px;
    margin-top:20px;
    color:#555;
}

.btn-primary{
    background:#163E73;
    border:none;
}

.btn-primary:hover{
    background:#0B1F3A;
}

.feature-card{
    border:none;
    border-radius:15px;
    transition:.3s;
}

.feature-card:hover{
    transform:translateY(-10px);
}

footer{
    background:#0B1F3A;
    color:#fff;
    padding:25px;
    margin-top:80px;
}

</style>

</head>

<body>

<nav class="navbar navbar-expand-lg navbar-dark fixed-top">

<div class="container">

<a class="navbar-brand fw-bold" href="#">

Cashflow Management

</a>

<button class="navbar-toggler"

data-bs-toggle="collapse"

data-bs-target="#menu">

<span class="navbar-toggler-icon"></span>

</button>

<div class="collapse navbar-collapse"

id="menu">

<ul class="navbar-nav ms-auto">

<li class="nav-item">

<a class="nav-link"

href="#">

Home

</a>

</li>

<li class="nav-item">

<a class="nav-link"

href="#features">

Features

</a>

</li>

<li class="nav-item">

<a class="nav-link"

href="#contact">

Contact

</a>

</li>

<li class="nav-item ms-3">

<a class="btn btn-light"

href="/cashflow-management/public/login">

Login

</a>

</li>

</ul>

</div>

</div>

</nav>

<section class="hero">

<div class="container">

<div class="row align-items-center">

<div class="col-lg-6">

<h1>

Professional Cashflow Management System

</h1>

<p>

Manage customers, deposits, withdrawals,

expenses and reports from one secure platform.

</p>

<div class="mt-4">

<a href="/cashflow-management/public/login"

class="btn btn-primary btn-lg me-3">

Get Started

</a>

<a href="/cashflow-management/public/login"

class="btn btn-outline-dark btn-lg">

Login

</a>

</div>

</div>

<div class="col-lg-6 text-center">

<img src="https://images.unsplash.com/photo-1554224155-6726b3ff858f?w=900"

class="img-fluid rounded">

</div>

</div>

</div>

</section>

<section id="features"

class="container">

<div class="row g-4">

<div class="col-md-4">

<div class="card feature-card shadow">

<div class="card-body text-center">

<i class="fas fa-users fa-3x text-primary mb-3"></i>

<h4>Customers</h4>

<p>

Manage all customer records.

</p>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card feature-card shadow">

<div class="card-body text-center">

<i class="fas fa-money-bill-wave fa-3x text-success mb-3"></i>

<h4>Transactions</h4>

<p>

Deposits and Withdrawals.

</p>

</div>

</div>

</div>

<div class="col-md-4">

<div class="card feature-card shadow">

<div class="card-body text-center">

<i class="fas fa-chart-line fa-3x text-danger mb-3"></i>

<h4>Reports</h4>

<p>

Daily Weekly Monthly Reports.

</p>

</div>

</div>

</div>

</div>

</section>

<footer class="text-center">

© <?= date('Y') ?>

Cashflow Management System.

All Rights Reserved.

</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>


<script>

window.addEventListener('scroll',function(){

const navbar=document.querySelector('.navbar');

if(window.scrollY>30){

navbar.classList.add('scrolled');

}else{

navbar.classList.remove('scrolled');

}

});

</script>
</body>

</html>