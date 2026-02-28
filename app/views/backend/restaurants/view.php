<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container">
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between align-items-center">
                <h1><?= htmlspecialchars($restaurant['title']) ?></h1>
                <a href="/restaurant" class="btn btn-success">Back</a>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <img src="<?= htmlspecialchars($restaurant['image_url']) ?>" class="img-fluid" alt="Restaurant Image">
                </div>
                <div class="col-md-6">
                    <h5>Description</h5>
                    <div><?= html_entity_decode($restaurant['description']) ?></div>
                    <p><strong>Ratings:</strong> <?= htmlspecialchars($restaurant['ratings']) ?> star</p>
                    <p><strong>Cuisines:</strong> <?= htmlspecialchars($restaurant['cuisines']) ?></p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($restaurant['location']) ?></p>
                    <p><strong>Number of Seats:</strong> <?= htmlspecialchars($restaurant['number_of_seats']) ?></p>
                    <p><strong>Contact Email:</strong> <?= htmlspecialchars($restaurant['contact_email']) ?></p>
                    <p><strong>Contact Phone:</strong> <?= htmlspecialchars($restaurant['contact_phone']) ?></p>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5>Session Information</h5>
                    <?php if (count($sessions) > 0) { ?>
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Start Time</th>
                                    <th>Duration (hours)</th>
                                    <th>Sessions Per Day</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sessions as $session) : ?>
                                    <tr>
                                        <td><?= htmlspecialchars($session['session_id']) ?></td>
                                        <td><?= htmlspecialchars($session['start_time']) ?></td>
                                        <td><?= htmlspecialchars($session['duration']) ?> hours</td>
                                        <td><?= htmlspecialchars($session['sessions_per_day']) ?><?= ($session['sessions_per_day'] == 1) ? ' session' : ' sessions' ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php } else { ?>
                        <p>No sessions available for this restaurant.</p>
                    <?php } ?>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5>Features</h5>
                    <?php if (!empty($restaurant['features'])) : ?>
                        <ul>
                            <?php foreach ($restaurant['features'] as $feature) : ?>
                                <li>
                                    <img src="<?= htmlspecialchars($feature['image_url']) ?>" alt="<?= htmlspecialchars($feature['name']) ?>" style="width: 20px; height: 20px;">
                                    <?= htmlspecialchars($feature['name']) ?>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php else : ?>
                        <p>No features available</p>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <h5>Gallery Images</h5>
                    <?php $galleryImages = json_decode($restaurant['gallery_images'], true); ?>
                    <?php if (!empty($galleryImages)) : ?>
                        <div class="row">
                            <?php foreach ($galleryImages as $image) : ?>
                                <div class="col-md-3 mb-2">
                                    <img src="<?= htmlspecialchars($image) ?>" alt="Gallery Image" class="img-fluid">
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else : ?>
                        <p>No gallery images available</p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>