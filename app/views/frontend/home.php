<?php include __DIR__ . '/inc/header.php'; ?>

<link rel="stylesheet" href="/frontend/css/home.css" />
<title>Home</title>
</head>

<body>
    <div id="section-1">
        <div class="festival-image">
            <img src="/assets/images/image9.png" alt="" />
            <h1>HAARLEM FESTIVAL</h1>
        </div>
    </div>
    <div class="section">
        <h2>The largest Haarlem summer events of 2026 at a glance!</h2>
        <section class="img-p">
            <img src="/assets/images/section-2.png" />
            <div class="p-button">
                <p>
                    HAARLEM - The moment that many are eagerly awaiting: spring and summer are starting again and so event organizations can also go wild again. Which major
                    events can you expect in Haarlem in 2026? Here you will find an overview!
                </p>
                <a href="#upcoming">Upcoming Events</a>
            </div>
        </section>
    </div>
    <div class="section-heading">
        <h2>Event Location</h2>
    </div>
    <div class="map">
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2433.744888616002!2d4.6141989!3d52.3961483!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ef6c60e1e9fb%3A0x8ae15680b8a17e39!2sHaarlem%2C%20Netherlands!5e0!3m2!1sen!2sin!4v1649839892387!5m2!1sen!2sin" width="1500" height="550" allowfullscreen="" loading="lazy"></iframe>
    </div>

    <div class="section-heading" id="upcoming">
        <h2>Upcoming Events</h2>
    </div>

    <div class="event-section">
        <div class="event-section__body">
            <?php foreach ($historyEvents as $historyEvent) : ?>
                <div class="event-section__image">
                    <img src="<?= '/images/' . $historyEvent['image_url']; ?> " alt="" />
                </div>
                <div class="event-section__text">
                    <h2><?= $historyEvent['title']; ?></h2>
                    <p><?= $historyEvent['description']; ?></p>
                </div>
                <a href="/home/page?slug=history&id=3" class="event-section__button" id="event-section__button-history">
                    <p><?= $historyEvent['start_date']; ?> till <?= $historyEvent['end_date']; ?></p>
                <?php endforeach; ?>
                </a>
        </div>
    </div>

    <div class="event-section">
        <div class="event-section__body" id="event-section__body-dj">
            <?php foreach ($danceEvents as $danceEvent) : ?>
                <div class="event-section__image">
                    <img src="<?= '/images/' . $danceEvent['image_url']; ?> " alt="" />
                </div>
                <div class="event-section__text" id="event-section__text-dj">
                    <h2><?= $danceEvent['title']; ?></h2>
                    <p><?= $danceEvent['description']; ?></p>
                </div>
                <a href="/home/page?slug=dance&id=5" class="event-section__button" id="event-section__button-dj">
                    <p><?= $danceEvent['start_date']; ?> till <?= $danceEvent['end_date']; ?></p>
                <?php endforeach; ?>
                </a>
        </div>
    </div>
    <div class="event-section">
        <div class="event-section__body" id="event-section__body-yummy">
            <?php foreach ($yummyEvents as $yummyEvent) : ?>
                <div class="event-section__image">
                    <img src="<?= '/images/' . $yummyEvent['image_url']; ?> " alt="" />
                </div>
                <div class="event-section__text" id="event-section__text-yummy">
                    <h2><?= $yummyEvent['title']; ?></h2>
                    <p><?= $yummyEvent['description']; ?></p>
                </div>
                <a href="/home/page?slug=yummy&id=7" class="event-section__button" id="event-section__button-yummy">
                    <p><?= $yummyEvent['start_date']; ?> till <?= $yummyEvent['end_date']; ?></p>
                <?php endforeach; ?>
                </a>
        </div>
    </div>
</body>

</html>

<?php include __DIR__ . '/inc/footer.php'; ?>


<script src="/frontend/js/home.js"></script>
