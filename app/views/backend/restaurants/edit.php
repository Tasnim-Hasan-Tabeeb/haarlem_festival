<?php include __DIR__ . '/../inc/header.php'; ?>

<style>

    .restaurant-main-image {
        width: 100%;
        height: 320px;
        object-fit: cover;
        border-radius: 8px;
    }

    .gallery-image {
        width: 100%;
        height: 160px;
        object-fit: cover;
        border-radius: 6px;
    }

    .feature-icon {
        width: 24px;
        height: 24px;
        object-fit: cover;
        border-radius: 50%;
    }


    .position-relative:hover .btn-danger {
        opacity: 1;
    }

    .position-relative .btn-danger {
        opacity: 0.9;
        transition: 0.2s ease;
    }

    .delete-btn {
        width:32px;
        height:32px;
        border-radius:50%;
        padding:0;
    }

    
</style>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1 class="mb-4">Edit Restaurant</h1>

    <form action="/restaurant/update" method="POST" enctype="multipart/form-data" autocomplete="off">

        <input type="hidden" name="id" value="<?= $restaurant['restaurant_id'] ?>">

        <!-- Event -->
        <div class="mb-3">
            <label class="form-label">
                Select Event <span class="text-danger">*</span>
            </label>
            <select class="form-select" name="event_id" required>
                <option value="">Select event</option>
                <?php foreach ($events as $event): ?>
                    <option value="<?= $event['event_id'] ?>"
                        <?= $restaurant['event_id'] == $event['event_id'] ? 'selected' : '' ?>>
                        <?= htmlspecialchars($event['title']) ?>
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
                   placeholder="Enter restaurant title"
                   value="<?= htmlspecialchars($restaurant['title']) ?>"
                   required>
        </div>

        <!-- Image -->
        <div class="mb-3">
            <label class="form-label">Thumbnail Image</label>

            <input type="file" name="image_url" class="form-control">

            <?php if (!empty($restaurant['image_url'])): ?>
                <img src="<?= $restaurant['image_url'] ?>"
                     class="mt-2 rounded border"
                     width="100"
                     height="100"
                     alt="Current Image">
            <?php endif; ?>
        </div>

        <!-- Description -->
        <div class="mb-3">
            <label class="form-label">
                Description <span class="text-danger">*</span>
            </label>

            <textarea class="form-control summernote"
                      name="description"
                      rows="4"
                      placeholder="Write restaurant description..."
                      required><?= ($restaurant['description']) ?></textarea>
        </div>

        <!-- Ratings + Cuisines -->
        <div class="row">
            <div class="col-md-4 mb-3">
                <label class="form-label">Ratings <span class="text-danger">*</span></label>
                <input type="number"
                       name="ratings"
                       class="form-control"
                       min="0"
                       max="5"
                       step="0.1"
                       placeholder="e.g. 4.5"
                       value="<?= htmlspecialchars($restaurant['ratings']) ?>"
                       required>
            </div>

            <div class="col-md-8 mb-3">
                <label class="form-label">Cuisines <span class="text-danger">*</span></label>
                <input type="text"
                       name="cuisines"
                       class="form-control"
                       placeholder="e.g. Italian, Chinese"
                       value="<?= htmlspecialchars($restaurant['cuisines']) ?>"
                       required>
            </div>
        </div>

        <!-- Features -->
        <div class="mb-3">
            <label class="form-label">Features <span class="text-danger">*</span></label>

            <select class="form-select" name="features[]" multiple required>
                <?php foreach ($features as $feature): ?>

                    <?php
                    $selected = false;
                    foreach ($selectedFeatures as $sf) {
                        if ($sf['feature_id'] === $feature['feature_id']) {
                            $selected = true;
                            break;
                        }
                    }
                    ?>

                    <option value="<?= $feature['feature_id'] ?>" <?= $selected ? 'selected' : '' ?>>
                        <?= htmlspecialchars($feature['name']) ?>
                    </option>

                <?php endforeach; ?>
            </select>
        </div>

        <!-- Location + Seats -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Location <span class="text-danger">*</span></label>
                <input type="text"
                       name="location"
                       class="form-control"
                       placeholder="e.g. Dhaka, Gulshan"
                       value="<?= htmlspecialchars($restaurant['location']) ?>"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Number of Seats <span class="text-danger">*</span></label>
                <input type="number"
                       name="number_of_seats"
                       class="form-control"
                       min="1"
                       placeholder="e.g. 50"
                       value="<?= htmlspecialchars($restaurant['number_of_seats']) ?>"
                       required>
            </div>
        </div>

        <!-- Pricing -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Price (Child) <span class="text-danger">*</span></label>
                <input type="number"
                       name="price_for_child"
                       class="form-control"
                       min="0"
                       step="any"
                       placeholder="0.00"
                       value="<?= htmlspecialchars($restaurant['price_for_child']) ?>"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Price (Adult) <span class="text-danger">*</span></label>
                <input type="number"
                       name="price_for_adult"
                       class="form-control"
                       min="0"
                       step="any"
                       placeholder="0.00"
                       value="<?= htmlspecialchars($restaurant['price_for_adult']) ?>"
                       required>
            </div>
        </div>

        <!-- Contact -->
        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Contact Email <span class="text-danger">*</span></label>
                <input type="email"
                       name="contact_email"
                       class="form-control"
                       placeholder="example@email.com"
                       value="<?= htmlspecialchars($restaurant['contact_email']) ?>"
                       required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">Contact Phone <span class="text-danger">*</span></label>
                <input type="tel"
                       name="contact_phone"
                       class="form-control"
                       placeholder="+8801XXXXXXXXX"
                       value="<?= htmlspecialchars($restaurant['contact_phone']) ?>"
                       required>
            </div>
        </div>

        <!-- Gallery -->
        <div class="mb-3">
            <label class="form-label">Gallery Images</label>

            <input type="file" name="gallery_image_url[]" class="form-control" multiple>

            <div class="row mt-3">

                <?php
                $galleryImages = json_decode($restaurant['gallery_images'], true);
                ?>

                <?php if (!empty($galleryImages)): ?>

                    <?php foreach ($galleryImages as $image): ?>

                        <div class="col-md-3 mb-3">

                            <div class="position-relative">

                                <img src="<?= $image ?>"
                                    class="img-fluid rounded border gallery-image"
                                    alt="Gallery Image">

                                <!-- Delete Button -->
                                <a href="/restaurant/unlinkGalleryImage?id=<?= $restaurant['restaurant_id'] ?>&image=<?= urlencode($image) ?>"
                                class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 d-flex align-items-center delete-btn  justify-content-center"
                                >

                                    <i class="fa fa-trash"></i>

                                </a>

                            </div>

                        </div>

                    <?php endforeach; ?>

                <?php else: ?>

                    <div class="text-muted">No images uploaded.</div>

                <?php endif; ?>

            </div>
        </div>

        <!-- Submit -->
        <button type="submit" class="btn btn-primary px-4">
            Update Restaurant
        </button>

    </form>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>