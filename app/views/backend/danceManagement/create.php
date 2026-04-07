<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1>Add Dance Event</h1>
    <div class="mt-4">
        <form action="/dancemanagement/store" method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="event_date" class="form-label">Event Date</label>
                <input type="date" class="form-control" id="event_date" name="event_date" required>
            </div>
            <div class="mb-3">
                <label for="event_start_time" class="form-label">Start Time</label>
                <input type="time" class="form-control" id="event_start_time" name="event_start_time" required>
            </div>
            <div class="mb-3">
                <label for="event_price" class="form-label">Price</label>
                <input type="number" step="0.01" min="0" class="form-control" id="event_price" name="event_price" required>
            </div>
            <div class="mb-3">
                <label for="event_duration" class="form-label">Duration (minutes)</label>
                <input type="number" min="1" class="form-control" id="event_duration" name="event_duration" required>
            </div>
            <div class="mb-3">
                <label for="session_type" class="form-label">Session Type</label>
                <select class="form-select" id="session_type" name="session_type" required>
                    <?php foreach ($sessionTypes as $type) : ?>
                        <option value="<?= $type ?>"><?= $type ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="venue_name" class="form-label">Venue</label>
                <select class="form-select" id="venue_name" name="venue_name" required>
                    <?php foreach ($venues as $venue) : ?>
                        <option value="<?= $venue['venue_id'] ?>"><?= $venue['venue_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="artist_id" class="form-label">Artists</label>
                <select class="form-select" id="artist_id" name="artist_id[]" multiple required>
                    <?php foreach ($artists as $artist) : ?>
                        <option value="<?= $artist['artist_id'] ?>"><?= $artist['artist_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-5">
                <label for="venue_image" class="form-label">Event Image</label>
                <input type="file" class="form-control" id="venue_image" name="venue_image">
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
