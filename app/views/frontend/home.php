<!DOCTYPE html>
<html lang="en">
<head>
    <?php include __DIR__ . '/inc/header.php'; ?>
    <link rel="stylesheet" href="/frontend/css/home.css" />
    <title>Home</title>
</head>

<body>
    <main>
        <header id="section-1">
            <div class="festival-image">
                <img src="/assets/images/image9.png" alt="Haarlem Festival banner" />
                <h1>HAARLEM FESTIVAL</h1>
            </div>
        </header>

        <section class="section">
            <h2>The largest Haarlem summer events of 2026 at a glance!</h2>

            <section class="img-p">
                <img src="/assets/images/section-2.png" alt="Haarlem summer events overview" />
                <div class="p-button">
                    <p>
                        HAARLEM - The moment that many are eagerly awaiting: spring and summer are starting again and so event organizations can also go wild again. Which major
                        events can you expect in Haarlem in 2026? Here you will find an overview!
                    </p>
                    <a href="#upcoming">Upcoming Events</a>
                </div>
            </section>
        </section>

        <section class="section-heading">
            <h2>Event Location</h2>
        </section>

        <section class="map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2433.744888616002!2d4.6141989!3d52.3961483!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ef6c60e1e9fb%3A0x8ae15680b8a17e39!2sHaarlem%2C%20Netherlands!5e0!3m2!1sen!2sin!4v1649839892387!5m2!1sen!2sin" width="1500" height="550" allowfullscreen="" loading="lazy"></iframe>
        </section>

        <section class="section-heading" id="upcoming">
            <h2>Upcoming Events</h2>
        </section>

        <section class="event-section">
            <div class="event-list">
                <?php foreach ($historyEvents as $historyEvent) : ?>
                    <article class="event-card">
                        <figure class="event-card__image">
                            <img src="<?= '/images/' . $historyEvent['image_url']; ?>" alt="<?= htmlspecialchars($historyEvent['title']); ?>" />
                        </figure>

                        <div class="event-card__content">
                            <h2 class="event-card__title"><?= $historyEvent['title']; ?></h2>
                            <p class="event-card__description"><?= $historyEvent['description']; ?></p>

                            <div class="event-card__footer">
                                <a href="/home/page?slug=history&id=3" class="event-card__button">
                                    <?= $historyEvent['start_date']; ?> till <?= $historyEvent['end_date']; ?>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>

                <?php foreach ($danceEvents as $danceEvent) : ?>
                    <article class="event-card">
                        <figure class="event-card__image">
                            <img src="<?= '/images/' . $danceEvent['image_url']; ?>" alt="<?= htmlspecialchars($danceEvent['title']); ?>" />
                        </figure>

                        <div class="event-card__content">
                            <h2 class="event-card__title"><?= $danceEvent['title']; ?></h2>
                            <p class="event-card__description"><?= $danceEvent['description']; ?></p>

                            <div class="event-card__footer">
                                <a href="/home/page?slug=dance&id=5" class="event-card__button">
                                    <?= $danceEvent['start_date']; ?> till <?= $danceEvent['end_date']; ?>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>

                <?php foreach ($yummyEvents as $yummyEvent) : ?>
                    <article class="event-card">
                        <figure class="event-card__image">
                            <img src="<?= '/images/' . $yummyEvent['image_url']; ?>" alt="<?= htmlspecialchars($yummyEvent['title']); ?>" />
                        </figure>

                        <div class="event-card__content">
                            <h2 class="event-card__title"><?= $yummyEvent['title']; ?></h2>
                            <p class="event-card__description"><?= $yummyEvent['description']; ?></p>

                            <div class="event-card__footer">
                                <a href="/home/page?slug=yummy&id=6" class="event-card__button">
                                    <?= $yummyEvent['start_date']; ?> till <?= $yummyEvent['end_date']; ?>
                                </a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
        </section>
    </main>

    <?php include __DIR__ . '/inc/footer.php'; ?>
    <script src="/frontend/js/home.js"></script>
</body>
</html>