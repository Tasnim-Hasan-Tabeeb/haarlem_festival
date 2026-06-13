<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1>Edit Event</h1>

    <div class="mt-4">
        <form action="/events/update" method="POST" autocomplete="off" enctype="multipart/form-data">

            <input type="hidden" name="event_id" value="<?= $event['event_id'] ?>">

            <div class="mb-3">
                <label for="title" class="form-label">Title <span class="text-danger">*</span></label>
                <input type="text"
                       class="form-control"
                       id="title"
                       name="title"
                       placeholder="Enter event title"
                       value="<?= htmlspecialchars($event['title']) ?>"
                       required>
            </div>

            <div class="mb-3">
                <label for="event_type" class="form-label">Event Type <span class="text-danger">*</span></label>
                <select class="form-select" id="event_type" name="event_type" required>
                    <option value="">Select event type</option>
                    <?php foreach ($eventtypes as $eventtype) : ?>
                        <option value="<?= $eventtype ?>"
                            <?= ($eventtype == $event['event_type']) ? 'selected' : '' ?>>
                            <?= $eventtype ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                <select class="form-select" id="event_type" name="status" required>
                    <option value="">Select status</option>
                    <option value="1" <?= ($event['status'] == 1) ? 'selected' : '' ?>>Active</option>
                    <option value="0" <?= ($event['status'] == 0) ? 'selected' : '' ?>>Inactive</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                <textarea class="form-control"
                          id="description"
                          name="description"
                          rows="5"
                          placeholder="Enter event description"
                          required><?= htmlspecialchars($event['description']) ?></textarea>
            </div>

            <div class="mb-3">
                <label for="start_date" class="form-label">Start Date <span class="text-danger">*</span></label>
                <input type="date"
                       class="form-control"
                       id="start_date"
                       name="start_date"
                       value="<?= $event['start_date'] ?>"
                       required>
            </div>

            <div class="mb-3">
                <label for="end_date" class="form-label">End Date <span class="text-danger">*</span></label>
                <input type="date"
                       class="form-control"
                       id="end_date"
                       name="end_date"
                       value="<?= $event['end_date'] ?>"
                       required>
            </div>

            <div class="mb-3">
                <label for="primary_theme_color" class="form-label">Primary Color <span class="text-danger">*</span></label>
                <input type="text"
                       class="form-control"
                       id="primary_theme_color"
                       name="primary_theme_color"
                       placeholder="#000000"
                       value="<?= htmlspecialchars($event['primary_theme_color']) ?>"
                       required>
            </div>

            <div class="mb-3">
                <label for="secondary_theme_color" class="form-label">Secondary Color <span class="text-danger">*</span></label>
                <input type="text"
                       class="form-control"
                       id="secondary_theme_color"
                       name="secondary_theme_color"
                       placeholder="#ffffff"
                       value="<?= htmlspecialchars($event['secondary_theme_color']) ?>"
                       required>
            </div>

            <div class="mb-3">
                <label for="image_url" class="form-label">Event Image</label>
                <input type="file"
                       class="form-control"
                       id="image_url"
                       name="image_url">

                <?php if (!empty($event['image_url'])): ?>
                    <img src="<?=  $event['image_url'] ?>"
                         class="mt-2 img-thumbnail"
                         width="100"
                         height="100"
                         alt="Event Image">
                <?php endif; ?>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>

        </form>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>