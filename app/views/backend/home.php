<?php include __DIR__ . '/inc/header.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="container py-3">

    <h1 class="mb-2">Admin Dashboard</h1>
    <h5 class="text-muted mb-4">Festival Overview</h5>

    <!-- 📊 CHARTS -->
    <div class="row g-3 mb-4">

        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Overview Analytics</h6>
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h6 class="mb-3">Distribution</h6>
                    <canvas id="pieChart"></canvas>
                </div>
            </div>
        </div>

    </div>

    <!-- 📦 CARDS -->
    <div class="row g-3">

        <!-- Users -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="/user" class="text-decoration-none">
                <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-primary small">Users</div>
                            <h4 class="mb-0 text-primary"><?= (int) $userCount ?></h4>
                        </div>
                        <i class="fas fa-users fa-lg text-primary"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Pages -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="/page" class="text-decoration-none">
                <div class="card border-0 shadow-sm bg-success bg-opacity-10">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-success small">Pages</div>
                            <h4 class="mb-0 text-success"><?= (int) $pageCount ?></h4>
                        </div>
                        <i class="fas fa-pager fa-lg text-success"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Events -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="/events" class="text-decoration-none">
                <div class="card border-0 shadow-sm bg-warning bg-opacity-10">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-warning small">Events</div>
                            <h4 class="mb-0 text-warning"><?= (int) $eventCount ?></h4>
                        </div>
                        <i class="fas fa-calendar fa-lg text-warning"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Orders -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="/manageorders" class="text-decoration-none">
                <div class="card border-0 shadow-sm bg-danger bg-opacity-10">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-danger small">Orders</div>
                            <h4 class="mb-0 text-danger"><?= (int) $orderCount ?></h4>
                        </div>
                        <i class="fas fa-shopping-cart fa-lg text-danger"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Restaurants -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="/restaurant" class="text-decoration-none">
                <div class="card border-0 shadow-sm bg-info bg-opacity-10">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-info small">Restaurants</div>
                            <h4 class="mb-0 text-info"><?= (int) $restaurantCount ?></h4>
                        </div>
                        <i class="fas fa-utensils fa-lg text-info"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Dance -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="/dancemanagement" class="text-decoration-none">
                <div class="card border-0 shadow-sm bg-secondary bg-opacity-10">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-secondary small">Dance Events</div>
                            <h4 class="mb-0 text-secondary"><?= (int) $danceEventCount ?></h4>
                        </div>
                        <i class="fas fa-music fa-lg text-secondary"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Artists -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="/artist" class="text-decoration-none">
                <div class="card border-0 shadow-sm bg-primary bg-opacity-10">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-primary small">Artists</div>
                            <h4 class="mb-0 text-primary"><?= (int) $artistCount ?></h4>
                        </div>
                        <i class="fas fa-compact-disc fa-lg text-primary"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- Venues -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="/venue" class="text-decoration-none">
                <div class="card border-0 shadow-sm bg-success bg-opacity-10">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-success small">Venues</div>
                            <h4 class="mb-0 text-success"><?= (int) $venueCount ?></h4>
                        </div>
                        <i class="fas fa-building fa-lg text-success"></i>
                    </div>
                </div>
            </a>
        </div>

        <!-- History -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="/historylocation" class="text-decoration-none">
                <div class="card border-0 shadow-sm bg-dark bg-opacity-10">
                    <div class="card-body d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-dark small">History</div>
                            <h4 class="mb-0 text-dark"><?= (int) $historyLocationCount ?></h4>
                        </div>
                        <i class="fas fa-history fa-lg text-dark"></i>
                    </div>
                </div>
            </a>
        </div>

    </div>
</div>

<script>
const labels = <?= json_encode(array_keys($dashboardStats)) ?>;
const values = <?= json_encode(array_values($dashboardStats)) ?>;

// BAR CHART
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'Total',
            data: values
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true }
        }
    }
});

// PIE CHART
new Chart(document.getElementById('pieChart'), {
    type: 'doughnut',
    data: {
        labels: labels,
        datasets: [{
            data: values
        }]
    }
});
</script>

<?php include __DIR__ . '/inc/footer.php'; ?>