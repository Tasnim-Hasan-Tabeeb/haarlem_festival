<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1 class="mb-4">Create Restaurant</h1>

    <form action="/restaurant/store"
          method="POST"
          enctype="multipart/form-data"
          autocomplete="off">

        <!-- Event -->
        <div class="mb-3">
            <label class="form-label">
                Select Event <span class="text-danger">*</span>
            </label>
            <select class="form-select" name="event_id" required>
                <option value="" disabled selected>Select event</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?= $event['event_id'] ?>">
                        <?= $event['title'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Title -->
        <div class="mb-3">
            <label class="form-label">
                Title <span class="text-danger">*</span>
            </label>
            <input type="text"
                   name="title"
                   class="form-control"
                   placeholder="Enter restaurant name"
                   required>
        </div>

        <!-- Image -->
        <div class="mb-3">
            <label class="form-label">
                Thumbnail Image <span class="text-danger">*</span>
            </label>
            <input type="file"
                   name="image_url"
                   class="form-control"
                   required>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label class="form-label">
                Description <span class="text-danger">*</span>
            </label>
            <textarea name="description"
                      class="form-control summernote"
                      rows="4"
                      placeholder="Write restaurant description..."
                      required></textarea>
        </div>

        <!-- Ratings -->
        <div class="mb-3">
            <label class="form-label">
                Ratings <span class="text-danger">*</span>
            </label>
            <input type="number"
                   name="ratings"
                   class="form-control"
                   min="0"
                   max="5"
                   step="0.1"
                   placeholder="e.g. 4.5"
                   required>
        </div>

        <!-- Cuisines -->
        <div class="mb-3">
            <label class="form-label">
                Cuisines <span class="text-danger">*</span>
            </label>
            <input type="text"
                   name="cuisines"
                   class="form-control"
                   placeholder="e.g. Italian, Chinese, Bengali"
                   required>
        </div>

        <!-- Features -->
        <div class="mb-3">
            <label class="form-label">
                Features <span class="text-danger">*</span>
            </label>
            <select class="form-select"
                    name="features[]"
                    multiple
                    required>
                <?php foreach ($features as $feature): ?>
                    <option value="<?= $feature['feature_id'] ?>">
                        <?= $feature['name'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- Location -->
        <div class="mb-3">
            <label class="form-label">
                Location <span class="text-danger">*</span>
            </label>
            <input type="text"
                   name="location"
                   class="form-control"
                   placeholder="e.g. Gulshan, Dhaka"
                   required>
        </div>

        <!-- Seats -->
        <div class="mb-3">
            <label class="form-label">
                Number of Seats <span class="text-danger">*</span>
            </label>
            <input type="number"
                   name="number_of_seats"
                   class="form-control"
                   min="1"
                   placeholder="e.g. 50"
                   max="100000"
                   required>
        </div>

        <!-- Prices -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">
                    Price (Child) <span class="text-danger">*</span>
                </label>
                <input type="number"
                       name="price_for_child"
                       class="form-control"
                       min="0"
                       step="any"
                       placeholder="0.00"
                       max="200000"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">
                    Price (Adult) <span class="text-danger">*</span>
                </label>
                <input type="number"
                       name="price_for_adult"
                       class="form-control"
                       min="0"
                       step="any"
                       placeholder="0.00"
                       max="200000"
                       required>
            </div>
        </div>

        <!-- Contact Email -->
        <div class="mb-3">
            <label class="form-label">
                Contact Email <span class="text-danger">*</span>
            </label>
            <input type="email"
                   name="contact_email"
                   class="form-control"
                   placeholder="example@email.com"
                   required>
        </div>

        <!-- Contact Phone -->
        <div class="mb-3">
            <label class="form-label">
                Contact Phone <span class="text-danger">*</span>
            </label>
            <input type="tel"
                   name="contact_phone"
                   class="form-control"
                   placeholder="+8801XXXXXXXXX"
                   required>
        </div>

        <!-- Gallery -->
        <div class="mb-4">
            <label class="form-label">
                Gallery Images <span class="text-danger">*</span>
            </label>
            <input type="file"
                   name="gallery_image_url[]"
                   class="form-control"
                   multiple
                   required>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary">
            Create Restaurant
        </button>

    </form>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>