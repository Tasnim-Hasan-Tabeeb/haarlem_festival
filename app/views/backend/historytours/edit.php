<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>


    <h1 class="mb-4">Edit History Tour</h1>

    <form action="/historytour/update" method="POST" autocomplete="off">

        <!-- Timeslot -->
        <div class="mb-3">
            <label for="timetable_id" class="form-label">
                Timeslot <span class="text-danger">*</span>
            </label>

            <select class="form-control"
                    id="timetable_id"
                    name="timetable_id"
                    required>

                <option value="">Select timeslot</option>

                <?php foreach ($timeslots as $timeslot): ?>
                    <option value="<?= $timeslot['timetable_id']; ?>"
                        <?= ($tour['timetable_id'] == $timeslot['timetable_id']) ? 'selected' : '' ?>>

                        <?= htmlspecialchars($timeslot['date']); ?>
                        (<?= htmlspecialchars($timeslot['start_time']); ?>
                        - <?= htmlspecialchars($timeslot['end_time']); ?>)

                    </option>
                <?php endforeach; ?>
            </select>

            <small class="text-muted">
                Choose a date and time range for this tour
            </small>
        </div>

        <!-- Language -->
        <div class="mb-3">
            <label for="language_id" class="form-label">
                Language <span class="text-danger">*</span>
            </label>

            <select class="form-control"
                    id="language_id"
                    name="language_id"
                    required>

                <option value="">Select language</option>

                <?php foreach ($languages as $language): ?>
                    <option value="<?= $language['language_id']; ?>"
                        <?= ($tour['language_id'] == $language['language_id']) ? 'selected' : '' ?>>

                        <?= htmlspecialchars($language['name']); ?>

                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Available Guides -->
        <div class="mb-3">
            <label for="available_guides" class="form-label">
                Available Guides <span class="text-danger">*</span>
            </label>

            <input type="number"
                   class="form-control"
                   id="available_guides"
                   name="available_guides"
                   min="0"
                   placeholder="Enter number of available guides"
                   value="<?= htmlspecialchars($tour['available_guides']); ?>"
                   required>

            <small class="text-muted">
                Enter how many guides are available for this tour
            </small>
        </div>

        <!-- Hidden ID -->
        <input type="hidden"
               name="tour_id"
               value="<?= htmlspecialchars($tour['tour_id']); ?>">

        <button type="submit" class="btn btn-primary">
            Update Tour
        </button>

    </form>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>