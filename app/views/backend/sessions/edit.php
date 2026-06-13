<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1 class="h3 mb-4">Edit Session</h1>

    <form action="/session/update" method="post" autocomplete="off" enctype="multipart/form-data">

        <div class="mb-3">
            <label for="event_id" class="form-label">Event  <span class="text-danger">*</span></label>
            <select name="event_id" id="event_id" class="form-select" required>
                <option value="">Select event</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?= $event['event_id']; ?>"
                        <?= ($session['event_id'] == $event['event_id']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($event['title']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="restaurant_id" class="form-label">Restaurant  <span class="text-danger">*</span></label>
            <select id="restaurant_id" name="restaurant_id" class="form-select" required>
                <option value="">Select restaurant</option>
                <?php foreach ($restaurants as $restaurant): ?>
                    <option value="<?= $restaurant['restaurant_id']; ?>"
                        <?= ($session['restaurant_id'] == $restaurant['restaurant_id']) ? 'selected' : ''; ?>>
                        <?= htmlspecialchars($restaurant['title']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <div class="col-md-4 mb-3">
                <label for="start_time" class="form-label">Start Time  <span class="text-danger">*</span></label>
                <input type="time"
                       class="form-control"
                       id="start_time"
                       name="start_time"
                       value="<?= htmlspecialchars($session['start_time']); ?>"
                       required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="duration" class="form-label">Duration (hours)  <span class="text-danger">*</span></label>
                <input type="number"
                       min="0.1"
                       step="any"
                       class="form-control"
                       id="duration"
                       name="duration"
                       value="<?= htmlspecialchars($session['duration']); ?>"
                       required>
            </div>

            <div class="col-md-4 mb-3">
                <label for="sessions_per_day" class="form-label">Sessions Per Day  <span class="text-danger">*</span> </label>
                <input type="number"
                       min="1"
                       class="form-control"
                       id="sessions_per_day"
                       name="sessions_per_day"
                       value="<?= htmlspecialchars($session['sessions_per_day']); ?>"
                       required>
            </div>
        </div>

        <input type="hidden" name="session_id" value="<?= $session['session_id']; ?>">

        <button type="submit" class="btn btn-primary">
            Update Session
        </button>

    </form>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>