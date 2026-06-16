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

    
</style>

<div class="container mb-5">

    <div class="card shadow-sm">

        <!-- HEADER -->
        <div class="card-header bg-white">
            <div class="d-flex justify-content-between align-items-center">
                <h3 class="mb-0"><?= htmlspecialchars($restaurant['title']) ?></h3>
                <a href="/restaurant" class="btn btn-success btn-sm">
                    Back
                </a>
            </div>
        </div>

        <div class="card-body">

            <div class="row g-4">

                <!-- IMAGE -->
                <div class="col-md-6">
                    <img src="<?= htmlspecialchars($restaurant['image_url']) ?>"
                         class="img-fluid rounded border restaurant-main-image"
                         alt="Restaurant Image">
                </div>

                <!-- DETAILS -->
                <div class="col-md-6">

                    <p><strong>Description:</strong></p>
                    <div class="mb-3">
                        <?= html_entity_decode($restaurant['description']) ?>
                    </div>

                    <p><strong>Ratings:</strong> <?= htmlspecialchars($restaurant['ratings']) ?> ⭐</p>
                    <p><strong>Cuisines:</strong> <?= htmlspecialchars($restaurant['cuisines']) ?></p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($restaurant['location']) ?></p>
                    <p><strong>Seats:</strong> <?= htmlspecialchars($restaurant['number_of_seats']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($restaurant['contact_email']) ?></p>
                    <p><strong>Phone:</strong> <?= htmlspecialchars($restaurant['contact_phone']) ?></p>

                </div>
            </div>

            <!-- SESSIONS -->
            <div class="mt-5">

                <h5 class="mb-3">Session Information</h5>

                <?php if (!empty($sessions)) : ?>

                    <div class="table-responsive">
                        <table class="table table-striped align-middle">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Start Time</th>
                                    <th>Duration</th>
                                    <th>Sessions / Day</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sessions as $session) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($session['session_id']) ?></td>
                                        <td><?= htmlspecialchars($session['start_time']) ?></td>
                                        <td><?= htmlspecialchars($session['duration']) ?> hrs</td>
                                        <td>
                                            <?= htmlspecialchars($session['sessions_per_day']) ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                <?php else : ?>
                    <p class="text-muted">No sessions available for this restaurant.</p>
                <?php endif; ?>

            </div>

            <!-- FEATURES -->
            <div class="mt-5">

                <h5 class="mb-3">Features</h5>

                <?php if (!empty($restaurant['features'])) : ?>

                    <ul class="list-group">

                        <?php foreach ($restaurant['features'] as $feature) : ?>
                            <li class="list-group-item d-flex align-items-center gap-2">
                                <img src="<?= htmlspecialchars($feature['image_url']) ?>"
                                     alt="<?= htmlspecialchars($feature['name']) ?>"
                                     class="rounded feature-icon"
                                     width="24"
                                     height="24">

                                <?= htmlspecialchars($feature['name']) ?>
                            </li>
                        <?php endforeach; ?>

                    </ul>

                <?php else : ?>
                    <p class="text-muted">No features available</p>
                <?php endif; ?>

            </div>

            <!-- GALLERY -->
            <div class="mt-5">

                <h5 class="mb-3">Gallery</h5>

                <?php $galleryImages = json_decode($restaurant['gallery_images'], true); ?>

                <?php if (!empty($galleryImages)) : ?>

                    <div class="row g-3">

                        <?php foreach ($galleryImages as $image) : ?>
                            <div class="col-6 col-md-3">
                                <img src="<?= htmlspecialchars($image) ?>"
                                     class="img-fluid rounded border gallery-image"
                                     alt="Gallery Image">
                            </div>
                        <?php endforeach; ?>

                    </div>

                <?php else : ?>
                    <p class="text-muted">No gallery images available</p>
                <?php endif; ?>

            </div>

        </div>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>