<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">
     <?php include __DIR__ . '/../inc/message.php'; ?>


    <h1 class="mb-4">Edit Venue</h1>

    <form action="/venue/update"
          method="post"
          autocomplete="off"
          enctype="multipart/form-data">

        <input type="hidden"
               name="venue_id"
               value="<?= htmlspecialchars($venue['venue_id']) ?>">

        <!-- NAME -->
        <div class="mb-3">
            <label class="form-label">
                Name <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control"
                   name="name"
                   value="<?= htmlspecialchars($venue['venue_name']) ?>"
                   placeholder="Enter venue name"
                   required
                   >
        </div>

        <!-- LOCATION -->
        <div class="mb-3">
            <label class="form-label">
                Location <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control"
                   name="location"
                   value="<?= htmlspecialchars($venue['venue_location']) ?>"
                   placeholder="Enter venue location"
                   required>
        </div>

        <!-- CAPACITY -->
        <div class="mb-3">
            <label class="form-label">
                Capacity <span class="text-danger">*</span>
            </label>
            <input type="number"
                   class="form-control"
                   name="capacity"
                   value="<?= htmlspecialchars($venue['capacity']) ?>"
                   placeholder="Enter capacity"
                   min="1"
                   required>
        </div>

        <!-- MAP -->
        <div class="mb-3">
            <label class="form-label">
                Map URL <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control"
                   name="map_url"
                   value="<?= htmlspecialchars($venue['map_url']) ?>"
                   placeholder="Paste Google Maps URL"
                   required>
        </div>

        <!-- IMAGE -->
        <div class="mb-4">
            <label class="form-label">Venue Image</label>

            <input type="file"
                   class="form-control"
                   name="venue_image"
                   accept="image/*"
                   >

            <?php if (!empty($venue['venue_image'])) : ?>
                <div class="mt-2">
                    <img src="<?=  $venue['venue_image'] ?>"
                         alt="Venue Image"
                         class="img-thumbnail"
                         width="100"
                         height="100">
                </div>
            <?php endif; ?>
        </div>

        <button type="submit" class="btn btn-primary">
            Update Venue
        </button>

    </form>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>