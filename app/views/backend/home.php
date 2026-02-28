<?php include __DIR__ . '/inc/header.php'; ?>
<style>
    .card-gradient-users {
        background: linear-gradient(135deg, #ff6f61, #d91e18);
        color: white;
    }

    .card-gradient-pages {
        background: linear-gradient(135deg, #36d1dc, #5b86e5);
        color: white;
    }

    .card-gradient-events {
        background: linear-gradient(135deg, #ff9a9e, #fad0c4);
        color: white;
    }

    .card-gradient-orders {
        background: linear-gradient(135deg, #7e5588, #7841a6);
        color: white;
    }
    .card-gradient-restaurants {
        background: linear-gradient(135deg, #a1c4fd, #c2e9fb);
        color: white;
    }

    .card-gradient-dance {
        background: linear-gradient(135deg, #fbc2eb, #a18cd1);
        color: white;
    }

    .card-gradient-artists {
        background: linear-gradient(135deg, #c78b3d, #dcafa2);
        color: white;
    }

    .card-gradient-venues {
        background: linear-gradient(135deg, #9cc949, #96e6a1);
        color: white;
    }

    .card-gradient-history-location {
        background: linear-gradient(135deg, #37c46c, #3c96c4);
        color: white;
    }

    .card-gradient-history-tours {
        background: linear-gradient(135deg, #fccb90, #d57eeb);
        color: white;
    }

</style>
<h1>Welcome to the Admin Dashboard</h1>

    <div class="container">
        <h1>Festival Overview</h1>
        <div class="row">
            <div class="col-md-4">
                <a href="/user" class="text-decoration-none">
                    <div class="card card-gradient-users mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Number of Users</h5>
                            <p class="card-text" style="font-size: 24px;"><?php echo $userCount; ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="/page" class="text-decoration-none">
                    <div class="card card-gradient-pages mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Number of Pages</h5>
                            <p class="card-text" style="font-size: 24px;"><?php echo $pageCount; ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="/events" class="text-decoration-none">
                    <div class="card card-gradient-events mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Number of Events</h5>
                            <p class="card-text" style="font-size: 24px;"><?php echo $eventCount; ?></p>
                        </div>
                    </div>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <a href="/restaurant" class="text-decoration-none">
                    <div class="card card-gradient-orders mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Number of Orders</h5>
                            <p class="card-text" style="font-size: 24px;"><?php echo $orderCount; ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="/manageorders" class="text-decoration-none">
                    <div class="card card-gradient-restaurants mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Number of Restaurants</h5>
                            <p class="card-text" style="font-size: 24px;"><?php echo $restaurantCount; ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="/dancemanagement" class="text-decoration-none">
                    <div class="card card-gradient-dance mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Number of Dance Events</h5>
                            <p class="card-text" style="font-size: 24px;"><?php echo $danceEventCount; ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="/artist" class="text-decoration-none">
                    <div class="card card-gradient-artists mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Number of Artists</h5>
                            <p class="card-text" style="font-size: 24px;"><?php echo $artistCount; ?></p>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-4">
                <a href="/venue" class="text-decoration-none">
                    <div class="card card-gradient-venues mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Number of Venues</h5>
                            <p class="card-text" style="font-size: 24px;"><?php echo $venueCount; ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="/historylocation" class="text-decoration-none">
                    <div class="card card-gradient-history-location mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Number of History Locations</h5>
                            <p class="card-text" style="font-size: 24px;"><?php echo $historyLocationCount; ?></p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-4">
                <a href="/historytour" class="text-decoration-none">
                    <div class="card card-gradient-history-tours mb-3">
                        <div class="card-body">
                            <h5 class="card-title">Number of History Tours</h5>
                            <p class="card-text" style="font-size: 24px;"><?php echo $historytimetableCount; ?></p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
<?php include __DIR__ . '/inc/footer.php'; ?>