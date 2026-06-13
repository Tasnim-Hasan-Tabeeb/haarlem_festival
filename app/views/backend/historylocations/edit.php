<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>


    <h1 class="mb-4">Edit Information</h1>

    <form action="/historylocation/update"
          method="post"
          autocomplete="off"
          enctype="multipart/form-data">

        <!-- NAME -->
        <div class="mb-3">
            <label class="form-label">
                Name <span class="text-danger">*</span>
            </label>

            <input type="text"
                   class="form-control"
                   name="location_name"
                   value="<?= htmlspecialchars($location['location_name']) ?>"
                   placeholder="Enter location name"
                   required>
        </div>

        <!-- DESCRIPTION -->
        <div class="mb-3">
            <label class="form-label">
                Description <span class="text-danger">*</span>
            </label>

            <textarea class="form-control"
                      name="description"
                      rows="5"
                      placeholder="Enter description"
                      required><?= htmlspecialchars($location['description']) ?></textarea>
        </div>

        <!-- ADDRESS -->
        <div class="mb-3">
            <label class="form-label">
                Address <span class="text-danger">*</span>
            </label>

            <input type="text"
                   class="form-control"
                   name="address"
                   value="<?= htmlspecialchars($location['address']) ?>"
                   placeholder="Enter address"
                   required>
        </div>

        <!-- CONTACT -->
        <div class="mb-3">
            <label class="form-label">
                Contact Info <span class="text-danger">*</span>
            </label>

            <input type="text"
                   class="form-control"
                   name="contact_info"
                   value="<?= htmlspecialchars($location['contact_info']) ?>"
                   placeholder="Enter contact information"
                   required>
        </div>

        <!-- IMAGE -->
        <div class="mb-4">
            <label class="form-label">Location Image</label>

            <input type="file"
                   class="form-control"
                   name="image_url"
                   accept="image/*">

            <?php if (!empty($location['images'])) : ?>
                <img src="<?= htmlspecialchars($location['images']) ?>"
                     alt="Location Image"
                     class="img-thumbnail mt-2 location-preview"
                     width="100"
                     height="100"
                     
                     >
            <?php endif; ?>
        </div>

        <!-- HIDDEN -->
        <input type="hidden"
               name="tour_location_id"
               value="<?= htmlspecialchars($location['tour_location_id']) ?>">

        <button type="submit" class="btn btn-primary">
            Update
        </button>

    </form>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>