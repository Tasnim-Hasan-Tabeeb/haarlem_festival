<?php include __DIR__ . '/../inc/header.php'; ?>

    <div class="container mb-5">
        <?php include __DIR__ . '/../inc/message.php'; ?>

        <h1>Add event</h1>
        <div class="mt-4">
            <form action="/events/store" method="POST" autocomplete="off" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" required>
                </div>
                <div class="mb-3">
                    <label for="event_image" class="form-label">Event Image</label>
                    <input type="file" class="form-control" id="event_image" name="image_url">
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea class="form-control" id="description" name="description" rows="4"></textarea>
                </div>
                <div class="mb-3">
                    <label for="event_date" class="form-label">Event Date</label>
                    <input type="date" class="form-control" id="event_date" name="event_date" required>
                </div>
                <div class="mb-3">
                    <label for="event_time" class="form-label">Event Time</label>
                    <input type="time" class="form-control" id="event_time" name="event_time" required>
                </div>
                <div class="mb-3">
                    <label for="price" class="form-label">Price</label>
                    <input type="text" class="form-control" id="price" name="price" required>
                </div>
                <div class="mb-3">
                    <label for="duration" class="form-label">Duration</label>
                    <input type="text" class="form-control" id="duration" name="duration" required>
                </div>
                <div class="mb-3">
                    <label for="session_type" class="form-label">Session Type</label>
                    <select class="form-select" id="event_type" name="event_type" required>
                    <?php foreach ($sessionTypes as $sessionType) : ?>
                        <option value="<?= $sessionType ?>">
                            <?=$sessionType?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="venue" class="form-label">Venue</label>
                    <select class="form-select" id="venue" name="venue" required>
                    <?php foreach ($venues as $venue) : ?>
                        <option value="<?= $venue['venue_id'] ?>">
                            <?=$venue['name']?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="artist" class="form-label">Artist</label>
                    <select class="form-select" id="artist" name="artist" required>
                    <?php foreach ($artists as $artist) : ?>
                        <option value="<?= $artist['artist_id'] ?>">
                            <?=$artist['artist_name']?>
                        </option>
                    <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="primary_theme_color" class="form-label">Primary Theme Color</label>
                    <input type="color" class="form-control form-control-color" id="primary_theme_color" name="primary_theme_color">
                </div>
                <div class="mb-3">
                    <label for="secondary_theme_color" class="form-label">Secondary Theme Color</label>
                    <input type="color" class="form-control form-control-color" id="secondary_theme_color" name="secondary_theme_color">
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
