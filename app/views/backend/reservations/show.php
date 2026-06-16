<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2 class="mb-0">Reservation Details</h2>
        <a href="/reservation" class="btn btn-outline-primary btn-sm">
            Back
        </a>
    </div>

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <div class="card shadow-sm border-0">
        
        <!-- Card Header -->
        <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
            <span>Reservation #<?= $reservation['reservation_id'] ?></span>

            <?php if ($reservation['is_active']) : ?>
                <span class="badge bg-success">Active</span>
            <?php else : ?>
                <span class="badge bg-secondary">Inactive</span>
            <?php endif; ?>
        </div>

        <!-- Card Body -->
        <div class="card-body">

            <div class="row g-4">

                <!-- Customer Info -->
                <div class="col-md-6">
                    <h6 class="text-muted border-bottom pb-2 mb-3">Customer Info</h6>

                    <p><strong>Name:</strong><br> <?= htmlspecialchars($reservation['name']) ?></p>
                    <p><strong>Email:</strong><br> <?= htmlspecialchars($reservation['email']) ?></p>
                    <p><strong>Phone:</strong><br> <?= htmlspecialchars($reservation['phone']) ?></p>
                </div>

                <!-- Reservation Info -->
                <div class="col-md-6">
                    <h6 class="text-muted border-bottom pb-2 mb-3">Reservation Info</h6>

                    <p><strong>Date:</strong><br> <?= htmlspecialchars($reservation['reservation_date']) ?></p>
                    <p><strong>Adults:</strong><br> <?= htmlspecialchars($reservation['total_adult']) ?></p>
                    <p><strong>Children:</strong><br> <?= htmlspecialchars($reservation['total_children']) ?></p>
                </div>

                <!-- Restaurant Info -->
                <div class="col-md-6">
                    <h6 class="text-muted border-bottom pb-2 mb-3">Restaurant</h6>

                    <p><strong>Restaurant Name:</strong><br> <?= htmlspecialchars($restaurant['title']) ?></p>
                </div>

                <!-- Session Info -->
                <div class="col-md-6">
                    <h6 class="text-muted border-bottom pb-2 mb-3">Session</h6>

                    <p>
                        <strong>Time:</strong><br>
                        <?= htmlspecialchars($session['start_time']) ?>
                        <span class="text-muted">
                            (<?= htmlspecialchars($session['duration']) ?> hrs)
                        </span>
                    </p>
                </div>

                <!-- Remarks -->
                <div class="col-12">
                    <h6 class="text-muted border-bottom pb-2 mb-3">Remarks</h6>

                    <div class="bg-light p-3 rounded">
                        <?= !empty($reservation['remarks'])
                            ? htmlspecialchars($reservation['remarks'])
                            : '<span class="text-muted">No remarks provided</span>' ?>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>