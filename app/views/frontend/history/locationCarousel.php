<!-- <link rel="stylesheet" href="/frontend/css/carousel.css"/> -->

<style>

    /* carousel.css — fixed layout */

.carousel-body {
    width: 100%;
}

#carousel-container {
    position: relative;
    width: 100%;
    overflow: hidden;
    border-radius: 12px;
    border: 1px solid #e0e0e0;
}

/* Hide radio inputs */
input[type="radio"][name="carousel"] {
    display: none;
}

/* Each slide: image + description side by side */
.carousel-item {
    display: none;
    flex-direction: row;
    align-items: stretch;
    background: #fff;
    min-height: 260px;
}

.carousel-item img {
    width: 45%;
    min-width: 200px;
    object-fit: cover;
    flex-shrink: 0;
    border-radius: 12px 0 0 12px;
}

#location-description {
    flex: 1;
    padding: 1.5rem;
    display: flex;
    flex-direction: column;
    justify-content: center;
}

#location-description h2 {
    font-size: 1.2rem;
    font-weight: 500;
    margin: 0 0 0.75rem;
}

#location-description p {
    font-size: 0.9rem;
    line-height: 1.7;
    color: #555;
    margin: 0;
}

/* Show active slide based on checked radio */
#location-0:checked ~ .carousel-item:nth-of-type(1),
#location-1:checked ~ .carousel-item:nth-of-type(2),
#location-2:checked ~ .carousel-item:nth-of-type(3) {
    display: flex;
}

/* Controls */
.carousel-controls {
    display: flex;
    gap: 8px;
    justify-content: center;
    margin-top: 12px;
}

.carousel-control {
    cursor: pointer;
    padding: 6px 14px;
    border-radius: 8px;
    border: 1px solid #ccc;
    font-size: 13px;
    font-weight: 500;
    color: #555;
    background: #fff;
    transition: background 0.15s, color 0.15s;
}

.carousel-control:hover {
    background: #f5f5f5;
    color: #111;
}


</style>

<div class="carousel-body">
    <div id="carousel-container">
        <?php foreach ($locations as $index => $location): ?>
            <input type="radio" name="carousel" id="location-<?= $index; ?>" <?php if ($index === 0) echo 'checked'; ?>>
            <div class="carousel-item">
                <img src="<?='/images/' . $location['images']?>" alt="<?= $location['location_name']; ?>">
                <div id="location-description">
                    <h2><?= $location['location_name']; ?>xxx</h2>
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


