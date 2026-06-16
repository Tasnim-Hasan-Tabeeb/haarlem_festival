<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1 class="h3 mb-4">Edit Dance Event</h1>

    <form action="/dancemanagement/update"
          method="POST"
          enctype="multipart/form-data"
          autocomplete="off">

        <input type="hidden"
               name="music_performance_id"
               value="<?= $dance['music_performance_id'] ?>">

            <input type="hidden"
        name="music_event_id"
        value="<?= $dance['music_event_id'] ?>">


        <div class="mb-3">

            <label class="form-label">
                Event <span class="text-danger">*</span>
            </label>
            <select name="event_id"
                    class="form-select"
                    required>
                <option value="">Select event</option>
                <?php foreach ($events as $event) : ?>
                    <option value="<?= $event['event_id'] ?>"
                            <?= $dance['event_id'] == $event['event_id'] ? 'selected' : '' ?>>
                        <?= $event['title'] ?>
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
                   value="<?= htmlspecialchars($dance['event_name']) ?>"
                   placeholder="Enter event title"
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
                   value="<?= htmlspecialchars($dance['event_date']) ?>"
                   required>
        </div>

        <!-- TIME -->
        <div class="mb-3">
            <label class="form-label">
                Start Time <span class="text-danger">*</span>
            </label>
            <input type="time"
                   name="event_start_time"
                   class="form-control"
                   value="<?= htmlspecialchars($dance['event_start_time']) ?>"
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
                   step="any"
                   min="0"
                   required
                   value="<?= htmlspecialchars($dance['event_price']) ?>"
                   placeholder="Enter price (e.g. 500)">
        </div>

        <!-- DURATION -->
        <div class="mb-3">
            <label class="form-label">
                Duration (minutes) <span class="text-danger">*</span>
            </label>
            <input type="number"
                   name="event_duration"
                   class="form-control"
                   step="any"
                   min="0"
                   required
                   value="<?= htmlspecialchars($dance['event_duration']) ?>"
                   placeholder="Enter duration (e.g. 60)">
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
                    <option value="<?= $type ?>"
                        <?= ($type == $dance['session_type']) ? 'selected' : '' ?>>
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
                    <option value="<?= $venue['venue_id'] ?>"
                        <?= ($venue['venue_id'] == $dance['venue_id']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($venue['venue_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- ARTISTS -->
        <div class="mb-3">
            <label class="form-label">
                Artists <span class="text-danger">*</span>
            </label>
            <select name="artist_id[]"
                    multiple
                    class="form-select"
                    required
                >
                <?php foreach ($artists as $artist) : ?>

                    <option value="<?= $artist['artist_id'] ?>"
                        <?= in_array($artist['artist_id'], $selectedArtistIds) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($artist['artist_name']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- IMAGE -->
        <div class="mb-4">
            <label class="form-label">
                Event Image
            </label>

            <input type="file"
                   name="music_event_image"
                   class="form-control"
                   accept="image/*">

            <?php if (!empty($dance['music_event_image'])) : ?>
                <div class="mt-2">
                    <img src="<?= htmlspecialchars($dance['music_event_image']) ?>"
                         class="img-thumbnail"
                         width="100"
                         height="100"
                         alt="Event Image">
                </div>
            <?php endif; ?>
        </div>

        <!-- SUBMIT -->
        <button type="submit"
                class="btn btn-primary px-4">
            Update Event
        </button>

    </form>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>