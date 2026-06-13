<?php include __DIR__ . '/../inc/header.php'; ?>

<link rel="stylesheet" href="/frontend/css/yummy.css" />

<div class="yf-container">

    <?php foreach ($sections as $section) : ?>
        <?php if ($section->getSectionType() === 'header') : ?>

            <!-- HERO / INTRO -->
            <section class="yf-hero">
                <div class="yf-hero__content">
                    <h1><?= $section->getSectionTitle() ?></h1>
                    <p class="yf-hero__subtitle"><?= $section->getSubSectionTitle() ?></p>
                    <div class="yf-hero__text"><?= $section->getContent() ?></div>

                    <a href="#restaurants-section" class="yf-btn">
                        Explore Restaurants →
                    </a>
                </div>

                <div class="yf-hero__image">
                    <img src="<?= $section->getImageUrl() ?>" alt="">
                </div>
            </section>

        <?php endif; ?>
    <?php endforeach; ?>


    <!-- RESTAURANTS -->
    <section id="restaurants-section" class="yf-section">

        <div class="yf-section__header">
            <h2>Restaurants</h2>
            <p>
                Discover top restaurants, explore cuisines, and book your experience.
            </p>
        </div>

        <div class="yf-grid">

            <?php foreach ($restaurants as $restaurant) : ?>
                <article class="yf-card">

                    <!-- IMAGE -->
                    <a href="/restaurant/details?id=<?= $restaurant['restaurant_id'] ?>" class="yf-card__image">
                        <img src="<?= $restaurant['image_url'] ?>" alt="">
                    </a>

                    <!-- BODY -->
                    <div class="yf-card__body">

                        <h3><?= htmlspecialchars($restaurant['title']); ?></h3>

                        <!-- rating -->
                        <div class="yf-rating">
                            <?php for ($i = 0; $i < 5; $i++): ?>
                                <?= $i < $restaurant['ratings'] ? '★' : '☆'; ?>
                            <?php endfor; ?>
                        </div>

                        <p class="yf-meta">
                            <?= htmlspecialchars($restaurant['cuisines']); ?>
                        </p>

                        <!-- FEATURES -->
                        <div class="yf-features">
                            <?php foreach ($restaurant['features'] as $feature) : ?>
                                <span>
                                    <img src="<?= $feature['image_url'] ?>" alt="">
                                    <?= $feature['name'] ?>
                                </span>
                            <?php endforeach; ?>
                        </div>

                        <!-- INFO -->
                        <div class="yf-info">
                            <p>📍 <?= htmlspecialchars($restaurant['location']); ?></p>
                            <p>📞 <?= htmlspecialchars($restaurant['contact_phone']); ?></p>
                            <?php if (!empty($restaurant['sessions'])): ?>
                                <p>⏰ <?= $restaurant['start_time']; ?> - <?= $restaurant['end_time']; ?></p>
                            <?php endif; ?>
                        </div>

                        <!-- PRICE -->
                        <div class="yf-price">
                            <div>
                                <span>Child</span>
                                <strong>€<?= number_format($restaurant['price_for_child'], 2) ?></strong>
                            </div>
                            <div>
                                <span>Adult</span>
                                <strong>€<?= number_format($restaurant['price_for_adult'], 2) ?></strong>
                            </div>
                        </div>

                        <!-- CTA -->
                        <a href="/restaurant/details?id=<?= $restaurant['restaurant_id'] ?>" class="yf-btn yf-btn--full">
                            Book Now →
                        </a>

                    </div>
                </article>
            <?php endforeach; ?>

        </div>
    </section>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>