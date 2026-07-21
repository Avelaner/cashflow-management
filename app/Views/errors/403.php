<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>403 - Access Denied</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

    <style>

        body{

            background:#f5f7fb;

            display:flex;

            align-items:center;

            justify-content:center;

            min-height:100vh;

            font-family:Arial, Helvetica, sans-serif;

        }

        .error-card{

            width:100%;

            max-width:550px;

            background:#fff;

            border-radius:20px;

            padding:50px;

            text-align:center;

            box-shadow:0 15px 40px rgba(0,0,0,.08);

        }

        .error-card i{

            font-size:70px;

            color:#dc3545;

            margin-bottom:20px;

        }

        .error-card h1{

            font-size:70px;

            font-weight:700;

            color:#0d3b66;

        }

        .error-card p{

            color:#6c757d;

            margin-bottom:30px;

        }

        .btn-dashboard{

            background:#0d3b66;

            color:#fff;

            border-radius:50px;

            padding:12px 25px;

            text-decoration:none;

            transition:.3s;

        }

        .btn-dashboard:hover{

            background:#082846;

            color:#fff;

        }

    </style>

</head>

<body>

<div class="error-card">

    <i class="fas fa-lock"></i>

    <h1>403</h1>

    <h4 class="mb-3">

        Access Denied

    </h4>

    <p>

        Sorry, you don't have permission to access this page.

    </p>

    <a href="<?= base_url('dashboard') ?>" class="btn-dashboard">

        <i class="fas fa-arrow-left me-2"></i>

        Back to Dashboard

    </a>

</div>

</body>

</html>