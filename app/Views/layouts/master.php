<?php require 'header.php'; ?>

<?php require 'navbar.php'; ?>

<div class="container-fluid">

    <div class="row">

        <div class="col-md-2 p-0">

            <?php require 'sidebar.php'; ?>

        </div>

        <div class="col-md-10">

            <?= $content ?>

        </div>

    </div>

</div>

<?php require 'footer.php'; ?>