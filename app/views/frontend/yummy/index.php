<link rel="stylesheet" href="/frontend/css/yummy.css" />
<?php include __DIR__ . '/../inc/header.php' ?>

<main>
    <div class="restaurants-page-spacer"></div>

    <?php foreach ($sections as $section) : ?>
        <?php if ($section->getSectionType() === 'header') : ?>
            <header class="restaurants-header-section">
                <div class="restaurants-header-content">
                    <h1 class="restaurants-header-title"><?= $section->getSectionTitle() ?></h1>
                    <p class="restaurants-header-subtitle"><?= $section->getSubSectionTitle() ?></p>
                    <div class="restaurants-header-text"><?= $section->getContent() ?></div>
                    <br>
                    <a href="#restaurants-section" class="restaurants-header-button">Check out Restaurants</a>
                </div>

                <div class="restaurants-header-image-wrap">
                    <img src="<?= $section->getImageUrl() ?>" class="restaurants-header-image" alt="<?= htmlspecialchars($section->getSectionTitle()) ?>" />
                </div>
            </header>
        <?php endif; ?>

        <section id="restaurants-section" class="restaurants-section">
            <div class="restaurants-section-top">
                <h2 class="restaurants-section-title">Restaurants</h2>
            </div>

            <h3 class="restaurants-section-subtitle">Explore the Restaurants</h3>
            <p class="restaurants-section-description">
                Check out the awesome restaurants joining the fun below! From creative street food to refined culinary dishes, each restaurant brings its own unique flavors to the festival. Pick your favorites, discover new tastes, and get ready for a delicious adventure in the heart of Haarlem.
                <br><br>
                During the festival, talented chefs and popular local spots come together to serve bite-sized dishes, signature specialties, and exciting new creations for you to enjoy. It’s the perfect chance to sample dishes from multiple restaurants in one place and experience the vibrant food scene that makes Haarlem so special.
            </p>

            <section class="restaurants-list">
                <?php foreach ($restaurants as $restaurant) : ?>
                    <article class="restaurant-card">
                        <a href="/restaurant/details?id=<?= $restaurant['restaurant_id'] ?>" class="restaurant-card-image-link">
                            <div class="restaurant-card-image" style="background-image: url('<?= $restaurant['image_url'] ?>');"></div>
                        </a>

                        <div class="restaurant-card-body">
                            <h4 class="restaurant-card-title"><?php echo htmlspecialchars($restaurant['title']); ?></h4>

                            <div class="restaurant-card-rating">
                                <?php for ($i = 0; $i < 5; $i++): ?>
                                    <?php echo $i < $restaurant['ratings'] ? '★' : '☆'; ?>
                                <?php endfor; ?>
                            </div>

                            <p class="restaurant-card-text">Food Type: <?php echo htmlspecialchars($restaurant['cuisines']); ?></p>
                            <p class="restaurant-card-text">Available Seats: <?php echo $restaurant['number_of_seats']; ?></p>

                            <div class="restaurant-features">
                                <?php foreach ($restaurant['features'] as $feature) : ?>
                                    <div class="restaurant-feature-item">
                                        <img src="<?= $feature['image_url'] ?>" width="25" height="25" class="restaurant-feature-image" alt="<?= htmlspecialchars($feature['name']) ?>" />
                                        <span class="restaurant-feature-name"><?= $feature['name'] ?></span>
                                    </div>
                                <?php endforeach; ?>
                            </div>

                            <div class="restaurant-card-info">
                                <p class="restaurant-card-info-text">
                                    <img src="/images/location-marker.png" class="restaurant-card-icon" alt="Location" />
                                    <?= htmlspecialchars($restaurant['location']); ?>
                                </p>

                                <p class="restaurant-card-info-text">
                                    <img src="/images/telephone.png" class="restaurant-card-icon" alt="Phone" />
                                    <?= htmlspecialchars($restaurant['contact_phone']); ?>
                                </p>

                                <?php if (!empty($restaurant['sessions'])): ?>
                                    <p class="restaurant-card-info-text">
                                        ⏰ <?= htmlspecialchars($restaurant['start_time']); ?> - <?= htmlspecialchars($restaurant['end_time']); ?>
                                    </p>
                                <?php endif; ?>
                            </div>

                            <div class="menu-price">
                                <div class="menu-price-text">
                                    👶 <strong>Child</strong>
                                    <span>€<?= number_format($restaurant['price_for_child'], 2) ?></span>

                                    🧑 <strong>Adult</strong>
                                    <span>€<?= number_format($restaurant['price_for_adult'], 2) ?></span>
                                </div>
                            </div>

                            <a href="/restaurant/details?id=<?= $restaurant['restaurant_id'] ?>" class="restaurant-book-button">Book Now</a>
                        </div>
                    </article>
                <?php endforeach; ?>
            </section>
        </section>
    <?php endforeach; ?>
</main>

<?php include __DIR__ . '/../inc/footer.php'; ?>

<script>
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            document.querySelector(this.getAttribute('href')).scrollIntoView({ behavior: 'smooth' });
        });
    });

    // hover effect for cards
    document.querySelectorAll('.restaurants-list > div').forEach(card => {
        card.addEventListener('mouseenter', () => card.style.transform = 'translateY(-5px)');
        card.addEventListener('mouseleave', () => card.style.transform = 'translateY(0)');
    });
});
</script>