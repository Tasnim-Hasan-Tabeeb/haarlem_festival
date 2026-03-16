<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">
    <h1>Add History Tour</h1>

    <div class="mt-4">
        <form action="/historytour/add" method="POST" autocomplete="off">
            <div class="mb-3">
                <label for="timetable_id" class="form-label">Timeslot</label>
                <select class="form-control" id="timetable_id" name="timetable_id" required>
                    <option value="">Select Timeslot</option>
                    <?php foreach ($timeslots as $timeslot): ?>
                        <option value="<?= $timeslot['timetable_id']; ?>">
                            <?= htmlspecialchars($timeslot['date']); ?>
                            (<?= htmlspecialchars($timeslot['start_time']); ?> - <?= htmlspecialchars($timeslot['end_time']); ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="language_id" class="form-label">Language</label>
                <select class="form-control" id="language_id" name="language_id" required>
                    <option value="">Select Language</option>
                    <?php foreach ($languages as $language): ?>
                        <option value="<?= $language['language_id']; ?>">
                            <?= htmlspecialchars($language['language_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="available_guides" class="form-label">Available Guides</label>
                <input type="number" class="form-control" id="available_guides" name="available_guides" min="0" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Tour</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>