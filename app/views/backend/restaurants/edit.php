<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1>Edit Restaurant</h1>
    <div class="mt-4">
        <form action="/restaurant/update" method="POST" autocomplete="off" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?= $restaurant['restaurant_id'] ?>">
            <div class="mb-3">
                <label for="event" class="form-label">Select Event</label>
                <select class="form-select" id="event" name="event_id" required>
                    <option value="" selected disabled>Select Event</option>
                    <?php foreach ($events as $key => $event) : ?>
                        <option value="<?= $event['event_id'] ?>" <?= $restaurant['event_id'] == $event['event_id'] ? 'selected' : '' ?>><?= $event['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="<?= $restaurant['title'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="image_url" class="form-label">Thumbnail Image</label>
                <input type="file" class="form-control" id="image_url" name="image_url">
                <img src="<?= $restaurant['image_url'] ?>" alt="Current Image" style="width: 100px;">
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control summernote" id="description" name="description" rows="3" required><?= $restaurant['description'] ?></textarea>
            </div>
            <div class="mb-3">
                <label for="ratings" class="form-label">Ratings</label>
                <input type="number" min="0" max="5" step="0.1" class="form-control" id="ratings" name="ratings" value="<?= $restaurant['ratings'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="cuisines" class="form-label">Cuisines</label>
                <input type="text" class="form-control" id="cuisines" name="cuisines" value="<?= $restaurant['cuisines'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="features" class="form-label">Features</label>
                <select class="form-select mt-3" id="features" name="features[]" multiple required>
                    <?php foreach ($features as $feature) : ?>
                        <?php
                        $selected = false;
                        foreach ($selectedFeatures as $selectedFeature) {
                            if ($selectedFeature['feature_id'] === $feature['feature_id']) {
                                $selected = true;
                                break;
                            }
                        }
                        ?>
                        <option value="<?= $feature['feature_id'] ?>" <?= $selected ? 'selected' : '' ?>><?= $feature['name'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" class="form-control" id="location" name="location" value="<?= $restaurant['location'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="number_of_seats" class="form-label">Number of Seats</label>
                <input type="number" min="1" class="form-control" id="number_of_seats" name="number_of_seats" value="<?= $restaurant['number_of_seats'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="contact_email" class="form-label">Contact Email</label>
                <input type="email" class="form-control" id="contact_email" name="contact_email" value="<?= $restaurant['contact_email'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="contact_phone" class="form-label">Contact Phone</label>
                <input type="tel" class="form-control" id="contact_phone" name="contact_phone" value="<?= $restaurant['contact_phone'] ?>" required>
            </div>
            <div class="mb-3">
                <label for="gallery_images" class="form-label">Gallery Images</label>
                <input type="file" class="form-control" id="image_url" name="gallery_image_url[]" multiple>
                <div class="row">
                    <?php
                    $galleryImages = json_decode($restaurant['gallery_images'], true);
                    if (!empty($galleryImages)) {
                        foreach ($galleryImages as $image) {
                    ?>
                            <div class="col-md-3 mb-3 mt-3">
                                <img src="<?= $image ?>" alt="Gallery Image" class="img-fluid" >
                            </div>
                        <?php
                        }
                    } else {
                        ?>
                        <div class="col">
                            No images uploaded.
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>

            <button type="submit" class="btn btn-primary">Update</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>