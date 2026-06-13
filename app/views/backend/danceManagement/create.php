<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1 class="h3 mb-4">Create Dance Event</h1>

    <form action="/dancemanagement/store"
          method="POST"
          enctype="multipart/form-data"
          autocomplete="off">

        <!-- EVENT -->
        <div class="mb-3">
            <label class="form-label">
                Event <span class="text-danger">*</span>
            </label>

            <select name="event_id"
                    class="form-select"
                    required>
                <option value="">Select event</option>

                <?php foreach ($events as $event) : ?>
                    <option value="<?= $event['event_id'] ?>">
                        <?= htmlspecialchars($event['title']) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <!-- TITLE -->
        <div class="mb-3">
            <label class="form-label">
                Name <span class="text-danger">*</span>
            </label>

            <input type="text"
                   name="event_name"
                   class="form-control"
                   placeholder="Enter event name"
                   required>
        </div>

        <!-- DATE -->
        <div class="mb-3">
            <label class="form-label">
                Event Date <span class="text-danger">*</span>
            </label>

            <input type="date"
                   name="event_date"
                   class="form-control"
                   required>
        </div>

        <!-- START TIME -->
        <div class="mb-3">
            <label class="form-label">
                Start Time <span class="text-danger">*</span>
            </label>

            <input type="time"
                   name="event_start_time"
                   class="form-control"
                   required>
        </div>

        <!-- PRICE -->
        <div class="mb-3">
            <label class="form-label">
                Price <span class="text-danger">*</span>
            </label>

            <input type="number"
                   name="event_price"
                   class="form-control"
                   min="0"
                   required
                   step="any"
                   placeholder="Enter price">
        </div>

        <!-- DURATION -->
        <div class="mb-3">
            <label class="form-label">
                Duration (minutes)  <span class="text-danger">*</span>
            </label>

            <input type="number"
                   name="event_duration"
                   min="0"
                   required
                   class="form-control"
                   placeholder="Enter duration">
        </div>

        <!-- SESSION TYPE -->
        <div class="mb-3">
            <label class="form-label">
                Session Type <span class="text-danger">*</span>
            </label>

            <select name="session_type"
                    class="form-select"
                    required>
                <option value="">Select session type</option>

                <?php foreach ($sessionTypes as $type) : ?>
                    <option value="<?= $type ?>">
                        <?= $type ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <!-- VENUE -->
        <div class="mb-3">
            <label class="form-label">
                Venue <span class="text-danger">*</span>
            </label>

            <select name="venue_id"
                    class="form-select"
                    required>
                <option value="">Select venue</option>

                <?php foreach ($venues as $venue) : ?>
                    <option value="<?= $venue['venue_id'] ?>">
                        <?= htmlspecialchars($venue['venue_name']) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <!-- ARTISTS (MULTI SELECT) -->
        <div class="mb-3">
            <label class="form-label">
                Artists <span class="text-danger">*</span>
            </label>

            <select name="artist_id[]"
                    multiple
                    class="form-select"
                    required>

                <?php foreach ($artists as $artist) : ?>
                    <option value="<?= $artist['artist_id'] ?>">
                        <?= htmlspecialchars($artist['artist_name']) ?>
                    </option>
                <?php endforeach; ?>

            </select>
        </div>

        <!-- IMAGE -->
        <div class="mb-4">
            <label class="form-label">
                Event Image  <span class="text-danger">*</span>
            </label>

            <input type="file"
                   name="music_event_image"
                   class="form-control"
                   required
                   accept="image/*">
        </div>

        <!-- SUBMIT -->
        <button type="submit"
                class="btn btn-success px-4">
            Create Event
        </button>

    </form>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>