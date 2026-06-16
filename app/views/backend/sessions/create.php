<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1>Create Session</h1>

    <div class="mt-4">
        <form action="/session/store" method="POST" autocomplete="off" enctype="multipart/form-data">

            <!-- Event -->
            <div class="mb-3">
                <label for="event_id" class="form-label">
                    Event <span class="text-danger">*</span>
                </label>

                <select name="event_id"
                        id="event_id"
                        class="form-select"
                        required>

                    <option value="">Select event</option>

                    <?php foreach ($events as $event): ?>
                        <option value="<?= $event['event_id']; ?>">
                            <?= htmlspecialchars($event['title']); ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <!-- Restaurant -->
            <div class="mb-3">
                <label for="restaurant_id" class="form-label">
                    Restaurant <span class="text-danger">*</span>
                </label>

                <select id="restaurant_id"
                        name="restaurant_id"
                        class="form-select"
                        required>

                    <option value="">Select restaurant</option>

                    <?php foreach ($restaurants as $restaurant) : ?>
                        <option value="<?= $restaurant['restaurant_id'] ?>">
                            <?= htmlspecialchars($restaurant['title']) ?>
                        </option>
                    <?php endforeach; ?>

                </select>
            </div>

            <!-- Start Time -->
            <div class="mb-3">
                <label for="start_time" class="form-label">
                    Start Time <span class="text-danger">*</span>
                </label>

                <input type="time"
                       class="form-control"
                       id="start_time"
                       name="start_time"
                       required>
            </div>

            <!-- Duration -->
            <div class="mb-3">
                <label for="duration" class="form-label">
                    Duration (hours) <span class="text-danger">*</span>
                </label>

                <input type="number"
                       class="form-control"
                       id="duration"
                       name="duration"
                       min="0.1"
                       step="0.1"
                       max="10000"
                       placeholder="e.g. 1.5"
                       required>
            </div>

            <!-- Sessions per day -->
            <div class="mb-3">
                <label for="sessions_per_day" class="form-label">
                    Sessions Per Day <span class="text-danger">*</span>
                </label>

                <input type="number"
                       class="form-control"
                       id="sessions_per_day"
                       name="sessions_per_day"
                       min="1"
                       max="10000"
                       placeholder="e.g. 3"
                       required>
            </div>

            <button type="submit" class="btn btn-primary">
                Create
            </button>

        </form>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>