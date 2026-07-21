<footer class="app-footer">

    <div class="footer-left">

        <span>
            © <?= date('Y') ?>
            Cashflow Management System
        </span>

    </div>


    <div class="footer-right">

        <span>
            All Rights Reserved
        </span>

        <span class="footer-divider">
            |
        </span>

        <span>
            Developed by
            <strong>
                Engr. Avela Nder Marcel
            </strong>
        </span>

    </div>

</footer>


<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js"></script>

<!-- ApexCharts -->
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

<!-- Global JS -->
<script src="<?= asset('js/app.js') ?>"></script>


<?php if (strtolower($title ?? '') === 'dashboard'): ?>

    <script src="<?= asset('js/dashboard.js') ?>"></script>

<?php endif; ?>


<?php if (strtolower($title ?? '') === 'login'): ?>

    <script src="<?= asset('js/auth.js') ?>"></script>

<?php endif; ?>


</body>

</html>