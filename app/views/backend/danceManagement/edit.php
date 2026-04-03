<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>


    <h1>Edit Venue</h1>
    <div class="mt-4">
        <form action="/dancemanagement/update" method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= $dance['event_name'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="event_date" class="form-label">Event Date</label>
                <input type="date" class="form-control" id="event_date" name="event_date" value="<?= $dance['event_date'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="event_start_time" class="form-label">Start Time</label>
                <input type="time" class="form-control" id="event_start_time" name="event_start_time" value="<?= $dance['event_start_time'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="event_price" class="form-label">Price</label>
                <input type="text" class="form-control" id="event_price" name="event_price" value="<?= $dance['event_price'] ?>">
            </div>
            <div class="mb-3">
                <label for="event_duration" class="form-label">Duration</label>
                <input type="text" class="form-control" id="event_duration" name="event_duration" value="<?= $dance['event_duration'] ?>">
            </div>
            <div class="mb-3">
                <label for="session_type" class="form-label">Session Type</label>
                <select class="form-select" id="session_type" name="session_type" required>
                    <?php foreach ($sessionTypes as $type) : ?>
                        <option value="<?= $type ?>" <?= ($type == $dance['session_type']) ? 'selected' : '' ?>><?= $type ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="venue_name" class="form-label">Venue</label>
                <select class="form-select" id="venue_name" name="venue_name" required>
                    <?php foreach ($venues as $venue) : ?>
                        <option value="<?= $venue['venue_id'] ?>" <?= ($venue['venue_id'] == $dance['venue_id']) ? 'selected' : '' ?>><?= $venue['venue_name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="artist_id" class="form-label">Artist</label>
                <select class="form-select" id="artist_id" name="artist_id[]" multiple>
                    <?php foreach ($artists as $artist) : ?>
                        <option value="<?= $artist['artist_id'] ?>" <?php if (in_array($artist['artist_id'], $selectedArtistIds)) echo 'selected'; ?>>
                            <?= $artist['artist_name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>



            <div class="mb-5">
                <label for="venue_image" class="form-label">Venue Image</label>
                <input type="file" class="form-control" id="venue_image" name="venue_image">
                <img src="<?= '/images/' . $dance['music_event_image'] ?>" class="mt-2" width="100" height="100" alt="Venue Image">
            </div>
            <input type="hidden" name="music_performance_id" value="<?= $dance['music_performance_id'] ?>">
            <button type="submit" class="btn btn-primary">Update</button>

        </form>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
