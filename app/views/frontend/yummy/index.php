<?php include __DIR__ . '/../inc/header.php' ?>

<link rel="stylesheet" href="/frontend/css/yummy.css" />

<div class="white-space"></div>

<?php foreach ($sections as $section) : ?>
    <?php if ($section->getSectionType() === 'header') : ?>
        <div class="intro">
            <div class="text">
                <h1><?= $section->getSectionTitle() ?></h1>
                <p><?= $section->getSubSectionTitle() ?></p>
                <?= $section->getContent() ?>
                <br>
                <a class="intro-button" href="#restaurants-section">Check out Restaurants</a>
            </div>
            <div class="img-wrap">
                <img src="<?= $section->getImageUrl() ?>" alt="<?= htmlspecialchars($section->getSectionTitle()) ?>" />
            </div>
        </div>
    <?php endif; ?>
<?php endforeach; ?>

<div id="restaurants-section" class="restaurants-section">
    <div class="restaurant-top-line">
        <h2>Restaurants</h2>
    </div>

    <h3 class="text">Explore the Restaurants</h3>
    <p class="description">
        Check out the awesome restaurants joining the fun below! From creative street food to refined culinary dishes, each restaurant brings its own unique flavors to the festival. Pick your favorites, discover new tastes, and get ready for a delicious adventure in the heart of Haarlem.

        During the festival, talented chefs and popular local spots come together to serve bite-sized dishes, signature specialties, and exciting new creations for you to enjoy. It’s the perfect chance to sample dishes from multiple restaurants in one place and experience the vibrant food scene that makes Haarlem so special.
    </p>

    <div class="restaurants-list">
        <?php foreach ($restaurants as $restaurant) : ?>
            <div class="restaurants-list-item">
                <a href="/restaurant/details?id=<?= $restaurant['restaurant_id'] ?>">
                    <div class="image" style="background-image: url('<?= htmlspecialchars($restaurant['image_url']); ?>');"></div>
                </a>

                <p><?= htmlspecialchars($restaurant['title']); ?></p>

                <div class="review">
                    <?php for ($i = 0; $i < 5; $i++): ?>
                        <?= $i < $restaurant['ratings'] ? '★' : '☆' ?>
                    <?php endfor; ?>
                </div>

                <span class="line"></span>

                <div class="restaurant-feature">
                    <img src="/images/food-type.png" alt="Food type" height="20" width="20" />
                    <p>Food Type: <?= htmlspecialchars($restaurant['cuisines']); ?></p>
                </div>

                <div class="restaurant-feature">
                    <img src="/images/seats.png" alt="Seats" height="20" width="20" />
                    <p>Available Seats: <?= htmlspecialchars($restaurant['number_of_seats']); ?></p>
                </div>

                <span class="line"></span>

                <div class="features-list">
                    <?php foreach ($restaurant['features'] as $feature) : ?>
                        <div class="feature">
                            <img src="<?= htmlspecialchars($feature['image_url']); ?>" width="40" height="40" alt="<?= htmlspecialchars($feature['name']); ?>" />
                            <span><?= htmlspecialchars($feature['name']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <span class="line"></span>

                <div class="restaurant-information">
                    <div class="info-item">
                        <img src="/images/location-marker.png" alt="Location" />
                        <p><?= htmlspecialchars($restaurant['location']); ?></p>
                    </div>

                    <div class="info-item">
                        <img src="/images/telephone.png" alt="Phone" />
                        <p><?= htmlspecialchars($restaurant['contact_phone']); ?></p>
                    </div>

                    <?php if (!empty($restaurant['sessions'])): ?>
                        <div class="info-item">
                            <img src="/images/time.png" alt="Time" />
                            <p><?= htmlspecialchars($restaurant['start_time']); ?> - <?= htmlspecialchars($restaurant['end_time']); ?></p>
                        </div>
                    <?php endif; ?>
                </div>

                <a href="/restaurant/details?id=<?= $restaurant['restaurant_id'] ?>">
                    <button class="yummy_explore_btn">
                        <span class="yummy_booknow">Book Now</span>
                    </button>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});
</script>