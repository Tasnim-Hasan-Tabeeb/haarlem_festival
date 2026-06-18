<?php include __DIR__ . '/inc/header.php'; ?>

<link rel="stylesheet" href="/frontend/css/home.css">

    <!-- ── Hero ──────────────────────────────────────────── -->
    <section class="hf-hero">
        <img class="hf-hero__img" src="<?= htmlspecialchars($section->getImageUrl()) ?>" alt="Haarlem Festival" />
        <h1 class="hf-hero__title">
            <? echo $section->getSectionTitle(); ?>
        </h1>
    </section>

    <!-- ── Intro card ────────────────────────────────────── -->
    <div class="hf-intro">
        <div class="hf-container">
            <div class="hf-intro__card">
                <h2 class="hf-intro__heading">
                    <? echo $instrucationSection->getSubSectionTitle(); ?>
                </h2>
                <div class="hf-intro__body">
                    <img class="hf-intro__image"  src="<?= htmlspecialchars($instrucationSection->getImageUrl()) ?>" alt="Haarlem events" />
                    <div class="hf-intro__copy">
                        <p class="hf-intro__text">
                             
                           <? echo $instrucationSection->getContent(); ?>

                        </p>
                        <a class="hf-intro__cta" href="#upcoming">Upcoming Events</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ── Event Location ────────────────────────────────── -->
    <div class="hf-container">
        <div class="hf-section-heading">
            <h2 class="hf-section-heading__title">Event Location</h2>
        </div>
        <div class="hf-map">
            <iframe
                class="hf-map__frame"
                src="<?= $instrucationSection->getMapUrl() ?>"
                allowfullscreen
                loading="lazy"
                title="Haarlem event location"
            ></iframe>
        </div>
    </div>

    <!-- ── Upcoming Events ───────────────────────────────── -->
    <div class="hf-container" id="upcoming">
        <div class="hf-section-heading">
            <h2 class="hf-section-heading__title">Upcoming Events</h2>
        </div>

        <div class="hf-events">

            <!-- History -->
            <?php foreach ($historyEvents as $historyEvent) : ?>
            <article class="hf-event-card hf-event-card--history">
                <div class="hf-event-card__image-wrap">
                    <img src="<?= htmlspecialchars($historyEvent['image_url']) ?>" alt="<?= htmlspecialchars($historyEvent['title']) ?>" />
                </div>
                <div class="hf-event-card__text">
                    <h3 class="hf-event-card__title"><?= htmlspecialchars($historyEvent['title']) ?></h3>
                    <p class="hf-event-card__desc"><?= htmlspecialchars($historyEvent['description']) ?></p>

                    <div class="hf-event-card__footer justify-content-center">

                        <a href="<?= htmlspecialchars($pageLinks['history'] ?? '#') ?>" class="hf-event-card__cta">
                            View Event →
                        </a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>

            <!-- Dance / DJ -->
            <?php foreach ($danceEvents as $danceEvent) : ?>
            <article class="hf-event-card hf-event-card--dance">
                <div class="hf-event-card__image-wrap">
                    <img src="<?= htmlspecialchars($danceEvent['image_url']) ?>" alt="<?= htmlspecialchars($danceEvent['title']) ?>" />
                </div>


                <div class="hf-event-card__text">
                    <h3 class="hf-event-card__title"><?= htmlspecialchars($danceEvent['title']) ?></h3>
                    <p class="hf-event-card__desc"><?= htmlspecialchars($danceEvent['description']) ?></p>

                    <div class="hf-event-card__footer">
                    
                        <a href="<?= htmlspecialchars($pageLinks['dance'] ?? '#') ?>" class="hf-event-card__cta">
                            View Event →
                        </a>
                    </div>
                </div>
            </article>
            <?php endforeach; ?>

            <!-- Yummy -->
            <?php foreach ($yummyEvents as $yummyEvent) : ?>
            <article class="hf-event-card hf-event-card--yummy">
                <div class="hf-event-card__image-wrap">
                    <img src="<?= htmlspecialchars($yummyEvent['image_url']) ?>" alt="<?= htmlspecialchars($yummyEvent['title']) ?>" />
                </div>


                 <div class="hf-event-card__text">
                    <h3 class="hf-event-card__title"><?= htmlspecialchars($yummyEvent['title']) ?></h3>
                    <p class="hf-event-card__desc"><?= htmlspecialchars($yummyEvent['description']) ?></p>

                    <div class="hf-event-card__footer">
                        <a href="<?= htmlspecialchars($pageLinks['yummy'] ?? '#') ?>" class="hf-event-card__cta">
                            View Event →
                        </a>
                    </div>
                </div>


            </article>
            <?php endforeach; ?>

        </div>
    </div>


<script src="/frontend/js/home.js"></script>
<?php include __DIR__ . '/inc/footer.php'; ?>
