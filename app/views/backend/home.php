<?php include __DIR__ . '/inc/header.php'; ?>

<h1 class="mb-3">Welcome to the Admin Dashboard</h1>

<div class="container px-0">
    <h4 class="text-muted mb-4">Festival Overview</h4>

    <div class="row g-3">

        <!-- Users -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="/user" class="text-decoration-none dashboard-link">
                <div class="card dashboard-card users">
                    <div class="card-body">
                        <div class="card-header-row">
                            <div class="card-icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <h6 class="card-title mb-0">Number of Users</h6>
                        </div>
                        <div class="card-value"><?php echo (int)$userCount; ?></div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Pages -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="/page" class="text-decoration-none dashboard-link">
                <div class="card dashboard-card pages">
                    <div class="card-body">
                        <div class="card-header-row">
                            <div class="card-icon">
                                <i class="fas fa-pager"></i>
                            </div>
                            <h6 class="card-title mb-0">Number of Pages</h6>
                        </div>
                        <div class="card-value"><?php echo (int)$pageCount; ?></div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Events -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="/events" class="text-decoration-none dashboard-link">
                <div class="card dashboard-card events">
                    <div class="card-body">
                        <div class="card-header-row">
                            <div class="card-icon">
                                <i class="fas fa-calendar"></i>
                            </div>
                            <h6 class="card-title mb-0">Number of Events</h6>
                        </div>
                        <div class="card-value"><?php echo (int)$eventCount; ?></div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Orders -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="/manageorders" class="text-decoration-none dashboard-link">
                <div class="card dashboard-card orders">
                    <div class="card-body">
                        <div class="card-header-row">
                            <div class="card-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                            <h6 class="card-title mb-0">Number of Orders</h6>
                        </div>
                        <div class="card-value"><?php echo (int)$orderCount; ?></div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Restaurants -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="/restaurant" class="text-decoration-none dashboard-link">
                <div class="card dashboard-card restaurants">
                    <div class="card-body">
                        <div class="card-header-row">
                            <div class="card-icon">
                                <i class="fas fa-utensils"></i>
                            </div>
                            <h6 class="card-title mb-0">Number of Restaurants</h6>
                        </div>
                        <div class="card-value"><?php echo (int)$restaurantCount; ?></div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Dance -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="/dancemanagement" class="text-decoration-none dashboard-link">
                <div class="card dashboard-card dance">
                    <div class="card-body">
                        <div class="card-header-row">
                            <div class="card-icon">
                                <i class="fas fa-music"></i>
                            </div>
                            <h6 class="card-title mb-0">Number of Dance Events</h6>
                        </div>
                        <div class="card-value"><?php echo (int)$danceEventCount; ?></div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Artists -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="/artist" class="text-decoration-none dashboard-link">
                <div class="card dashboard-card artists">
                    <div class="card-body">
                        <div class="card-header-row">
                            <div class="card-icon">
                                <i class="fas fa-compact-disc"></i>
                            </div>
                            <h6 class="card-title mb-0">Number of Artists</h6>
                        </div>
                        <div class="card-value"><?php echo (int)$artistCount; ?></div>
                    </div>
                </div>
            </a>
        </div>

        <!-- Venues -->
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="/venue" class="text-decoration-none dashboard-link">
                <div class="card dashboard-card venues">
                    <div class="card-body">
                        <div class="card-header-row">
                            <div class="card-icon">
                                <i class="fas fa-building"></i>
                            </div>
                            <h6 class="card-title mb-0">Number of Venues</h6>
                        </div>
                        <div class="card-value"><?php echo (int)$venueCount; ?></div>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/inc/footer.php'; ?>