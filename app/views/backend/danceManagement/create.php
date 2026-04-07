<?php include __DIR__ . '/../inc/header.php'; ?>

    <div class="container mb-5">
        <?php include __DIR__ . '/../inc/message.php'; ?>

        <h1>Add Venue</h1>
        <div class="mt-4">
            <form action="/venue/store" method="POST" autocomplete="off" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>
                <div class="mb-3">
                    <label for="venue_image" class="form-label">Venue Image</label>
                    <input type="file" class="form-control" id="venue_image" name="venue_image">
                </div>
                <div class="mb-3">
                    <label for="location" class="form-label">Location</label>
                    <input type="text" class="form-control" id="location" name="location" required>
                </div>
                <div class="mb-3">
                    <label for="capacity" class="form-label">Capacity</label>
                    <input type="text" class="form-control" id="capacity" name="capacity" required>
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>

<?php include __DIR__ . '/../inc/footer.php'; ?>