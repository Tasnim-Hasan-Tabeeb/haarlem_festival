<link rel="stylesheet" href="/frontend/css/historyCarousel.css" />

<div class="carousel-body">
    <div id="carousel-container">
        <?php foreach ($locations as $index => $location): ?>
            <input
                type="radio"
                name="carousel"
                id="location-<?= $index; ?>"
                <?php if ($index === 0) echo 'checked'; ?>
            >

            <div class="carousel-item">
                <img
                    src="<?= '/images/' . htmlspecialchars($location['images']); ?>"
                    alt="<?= htmlspecialchars($location['location_name']); ?>"
                >

                <div class="location-description">
                    <h2><?= htmlspecialchars($location['location_name']); ?></h2>
                    <p><?= $location['description']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="carousel-controls">
        <?php foreach ($locations as $index => $location): ?>
            <label class="carousel-control" for="location-<?= $index; ?>">
                <?= chr(65 + $index); ?>
            </label>
        <?php endforeach; ?>
    </div>
</div>