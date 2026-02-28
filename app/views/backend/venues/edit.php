<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">
    <h1>Edit Venue</h1>
    <div class="mt-4">
        <form action="/venue/update" method="post" autocomplete="off" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= $venue['venue_name'] ?>"
                       required>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="<?= $venue['venue_location'] ?>"
                       required>
            </div>
            <div class="mb-3">
                <label for="capacity" class="form-label">Capacity</label>
                <input type="text" class="form-control" id="capacity" name="capacity" value="<?= $venue['capacity'] ?>"
                       required>
            </div>
            <div class="mb-3">
                <label for="map_url" class="form-label">Map URL</label>
                <input type="text" class="form-control" id="map_url" name="map_url" value="<?= $venue['map_url'] ?>"
                       required>
            </div>
            <div class="mb-5">
                <label for="venue_image" class="form-label">Venue Image</label>
                <input type="file" class="form-control" id="venue_image" name="venue_image">
                <img src="<?= '/images/' . $venue['venue_image'] ?>" class="mt-2" width="100" height="100" alt="Venue Image">
            </div>
            <input type="hidden" name="venue_id" value="<?= $venue['venue_id'] ?>">
            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
