<?php include __DIR__ . '/../inc/header.php'; ?>

    <div class="container mb-5">
        <h1>Add Location</h1>
        <div class="mt-4">
            <form action="/historylocation/add" method="POST" autocomplete="off" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="name" class="form-label">Title</label>
                    <input type="text" class="form-control" id="location_name" name="location_name" required>
                </div>
                <div class="mb-3">
                    <label for="about" class="form-label">Description</label>
                    <textarea class = "form-control" id="Description" name="description" rows="5" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="genre" class="form-label">Address</label>
                    <input type="text" class="form-control" id="address" name="address" required>
                </div>
                <div class="mb-3">
                    <label for="nationality" class="form-label">Contact Info</label>
                    <input type="text" class="form-control" id="contact_info" name="contact_info" required>
                </div>
                <div class="mb-3">
                    <label for="image_url" class="form-label">Location Image</label>
                    <input type="file" class="form-control" id="image_url" name="image_url">
                </div>
                <button type="submit" class="btn btn-primary">Create</button>
            </form>
        </div>
    </div>

<?php include __DIR__ . '/../inc/footer.php'; ?>