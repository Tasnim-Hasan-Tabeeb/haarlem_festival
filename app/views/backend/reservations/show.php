<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">
    <h1>Reservation Details</h1>
    <?php include __DIR__ . '/../inc/message.php'; ?>
    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Reservation ID: <?= $reservation['reservation_id'] ?></h5>
            <p class="card-text">Name: <?= htmlspecialchars($reservation['name']) ?></p>
            <p class="card-text">Date: <?= htmlspecialchars($reservation['reservation_date']) ?></p>
            <p class="card-text">Total Adults: <?= htmlspecialchars($reservation['total_adult']) ?></p>
            <p class="card-text">Total Children: <?= htmlspecialchars($reservation['total_children']) ?></p>
            <p class="card-text">Email: <?= htmlspecialchars($reservation['email']) ?></p>
            <p class="card-text">Phone: <?= htmlspecialchars($reservation['phone']) ?></p>
            <p class="card-text">Remarks: <?= ($reservation['remarks']) ? $reservation['remarks'] : "No Remarks" ?></p>
            <p class="card-text">Restaurant: <?= htmlspecialchars($restaurant['title']) ?></p>
            <p class="card-text">Session: <?= htmlspecialchars($session['start_time']) ?> (<?= htmlspecialchars($session['duration']) ?> hours)</p>
            <p class="card-text">Status: <?= $reservation['is_active'] ? 'Active' : 'Inactive' ?></p>
            <a href="/reservation" class="btn btn-primary">Back to Reservations</a>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
