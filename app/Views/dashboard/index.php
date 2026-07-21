<div class="container-fluid">

    <!-- Welcome Section -->
    <div class="welcome-mobile mb-4">
        <?php
        $hour = (int) date('H');
        if ($hour < 12) {
            $greeting = 'Good Morning 👋';
        } elseif ($hour < 17) {
            $greeting = 'Good Afternoon 👋';
        } else {
            $greeting = 'Good Evening 👋';
        }
        ?>
        <small class="text-muted"><?= $greeting ?></small>
        <h3 class="fw-bold"><?= htmlspecialchars(\App\Services\Auth::user()['fullname']) ?></h3>
        <small class="text-secondary"><?= date('l, d M Y') ?></small>
    </div>

    <!-- Statistics -->
    <?php require __DIR__ . '/widgets/stats.php'; ?>

    <!-- Charts & Summary -->
    <div class="row mt-4">
        <div class="col-lg-8">
            <?php require __DIR__ . '/widgets/cashflow-chart.php'; ?>
        </div>
        <div class="col-lg-4">
            <?php require __DIR__ . '/widgets/summary.php'; ?>
        </div>
    </div>

    

    <!-- Quick Actions -->
    <div class="row mt-4">
        <div class="col-12">
            <?php require __DIR__ . '/widgets/quick-actions.php'; ?>
        </div>
    </div>

</div>