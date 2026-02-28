<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1>Create Session</h1>
    <div class="mt-4">
        <form action="/session/store" method="POST" autocomplete="off" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="restaurant_id" class="form-label">Restaurant</label>
                <select id="restaurant_id" name="restaurant_id" class="form-control" required>
                    <?php foreach ($restaurants as $restaurant) : ?>
                        <option value="<?= $restaurant['restaurant_id'] ?>"><?= $restaurant['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="start_time" class="form-label">Start Time</label>
                <input type="time" class="form-control" id="start_time" name="start_time" required>
            </div>
            <div class="mb-3">
                <label for="duration" class="form-label">Duration (each session in hours)</label>
                <input type="number" min="0.1" step="any" class="form-control" id="duration" name="duration" required>
            </div>
            <div class="mb-3">
                <label for="sessions_per_day" class="form-label">Sessions Per Day</label>
                <input type="number" min="1" class="form-control" id="sessions_per_day" name="sessions_per_day" required>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>