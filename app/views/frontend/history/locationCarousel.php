<link rel="stylesheet" href="/frontend/css/carousel.css"/>

<div class="carousel-body">
    <div id="carousel-container">
        <?php foreach ($locations as $index => $location): ?>
            <input type="radio" name="carousel" id="location-<?= $index; ?>" <?php if ($index === 0) echo 'checked'; ?>>
            <div class="carousel-item">
                <img src="<?='/images/' . $location['images']?>" alt="<?= $location['location_name']; ?>">
                <div id="location-description">
                    <h2><?= $location['location_name']; ?></h2>
                    <p><?= $location['description']; ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="carousel-controls">
        <?php foreach ($locations as $index => $location): ?>
            <label class="carousel-control" for="location-<?php echo $index; ?>"><?php echo chr(65 + $index); ?></label>
        <?php endforeach; ?>
    </div>
</div>


