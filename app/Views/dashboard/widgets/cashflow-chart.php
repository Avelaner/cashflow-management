<div class="dashboard-card">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h5 class="mb-1 fw-bold">
                Cashflow
            </h5>
            <small class="text-muted">
                Overview of cash movement
            </small>
        </div>

        <div>
            <select class="form-select form-select-sm" id="cashflowFilter" style="width:150px;">
                <option value="monthly" selected>Monthly</option>
                <option value="weekly">Weekly</option>
                <option value="daily">Daily</option>
            </select>
        </div>
    </div>

    <div style="height:350px;">
        <canvas id="cashflowChart"></canvas>
    </div>

</div>

<!-- Include Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById('cashflowChart');
    const filterSelect = document.getElementById('cashflowFilter');
    if (!ctx) return;

    let cashflowChart = null;

    // Function to render or update chart
    function renderChart(labels, data) {
        if (cashflowChart) {
            cashflowChart.destroy(); // Destroy previous instance before re-drawing
        }

        cashflowChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Cash Inflow (₦)',
                    data: data,
                    borderColor: '#0d6efd',
                    backgroundColor: 'rgba(13, 110, 253, 0.08)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.35,
                    pointRadius: 4,
                    pointBackgroundColor: '#0d6efd'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                let value = context.parsed.y || 0;
                                return ' Cash Inflow: ₦' + value.toLocaleString('en-US', {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: {
                        beginAtZero: true,
                        ticks: {
                            callback: function (value) {
                                return '₦' + value.toLocaleString();
                            }
                        },
                        grid: { color: 'rgba(0, 0, 0, 0.05)' }
                    }
                }
            }
        });
    }

    // Fetch data from API endpoint
    function loadCashflowData(period) {
        fetch(`<?= base_url('api/cashflow-data') ?>?period=${period}`)
            .then(response => response.json())
            .then(res => {
                renderChart(res.labels, res.data);
            })
            .catch(error => console.error('Error loading cashflow data:', error));
    }

    // Initial Load (Monthly)
    loadCashflowData('monthly');

    // Filter Switch Event Listener
    filterSelect.addEventListener('change', function () {
        loadCashflowData(this.value);
    });
});
</script>