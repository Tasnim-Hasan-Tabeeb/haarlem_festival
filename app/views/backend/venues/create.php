<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

  <?php include __DIR__ . '/../inc/message.php'; ?>


    <h1 class="mb-4">Add Venue</h1>

    <form action="/venue/store"
          method="POST"
          autocomplete="off"
          enctype="multipart/form-data">

        <!-- NAME -->
        <div class="mb-3">
            <label class="form-label">
                Name <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control"
                   name="name"
                   placeholder="Enter venue name"
                   required>
        </div>

        <!-- IMAGE -->
        <div class="mb-3">
            <label class="form-label">Venue Image <span class="text-danger">*</span></label>
            <input type="file"
                   class="form-control"
                   name="venue_image"
                   required
                   accept="image/*">
        </div>

        <!-- LOCATION -->
        <div class="mb-3">
            <label class="form-label">
                Location <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control"
                   name="location"
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
                   placeholder="Enter capacity (e.g. 500)"
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
                   placeholder="Paste Google Maps URL"
                   required>
        </div>

        <button type="submit" class="btn btn-primary">
            Create Venue
        </button>

    </form>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>