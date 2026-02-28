<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1>Edit Reservation</h1>
    <div class="mt-4">
        <form action="/reservation/update" method="POST" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $reservation['reservation_id'] ?>">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= htmlspecialchars($reservation['name']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="reservation_date" class="form-label">Reservation Date</label>
                <input type="date" class="form-control" id="reservation_date" name="reservation_date" value="<?= htmlspecialchars($reservation['reservation_date']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="total_adult" class="form-label">Total Adults</label>
                <input type="number" min="1" class="form-control" id="total_adult" name="total_adult" value="<?= htmlspecialchars($reservation['total_adult']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="total_children" class="form-label">Total Children</label>
                <input type="number" min="0" class="form-control" id="total_children" name="total_children" value="<?= htmlspecialchars($reservation['total_children']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?= htmlspecialchars($reservation['email']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" value="<?= htmlspecialchars($reservation['phone']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="restaurant_id" class="form-label">Restaurant</label>
                <select id="restaurant_id" name="restaurant_id" class="form-control" required onchange="updateSessions()">
                    <option value="">Select Restaurant</option>
                    <?php foreach ($restaurants as $restaurant) : ?>
                        <option value="<?= $restaurant['restaurant_id'] ?>" <?= $restaurant['restaurant_id'] == $reservation['restaurant_id'] ? 'selected' : '' ?>>
                            <?= $restaurant['title'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="session_id" class="form-label">Session</label>
                <select id="session_id" name="session_id" class="form-control" required>
                    <option value="">Select Session</option>
                    <?php foreach ($restaurants as $restaurant) : ?>
                        <?php if ($restaurant['restaurant_id'] == $reservation['restaurant_id']) : ?>
                            <?php foreach ($restaurant['sessions'] as $session) : ?>
                                <option value="<?= $session['session_id'] ?>" <?= $session['session_id'] == $reservation['session_id'] ? 'selected' : '' ?>>
                                    <?= $session['start_time'] ?> (<?= $session['duration'] ?> hours)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="remarks" class="form-label">Remarks</label>
                <textarea id="remarks" name="remarks" class="form-control"><?= htmlspecialchars($reservation['remarks']) ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const restaurants = <?= json_encode($restaurants) ?>;

    function updateSessions() {
        const restaurantId = document.getElementById('restaurant_id').value;
        const sessionSelect = document.getElementById('session_id');
        sessionSelect.innerHTML = '<option value="">Select Session</option>';

        if (restaurantId) {
            const selectedRestaurant = restaurants.find(restaurant => restaurant.restaurant_id == restaurantId);
            selectedRestaurant.sessions.forEach(session => {
                const option = document.createElement('option');
                option.value = session.session_id;
                option.text = `${session.start_time} (${session.duration} hours)`;
                sessionSelect.add(option);
            });
        }
    }
</script>

<?php include __DIR__ . '/../inc/footer.php'; ?>