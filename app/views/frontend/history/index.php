<?php include __DIR__ . '/../inc/header.php'; ?>
<link rel="stylesheet" href="/frontend/css/history.css"/>


<div class="white-space"></div>
<?php foreach ($headers as $header): ?>
    <header class="masthead" style="background-image: url('<?= '/images/' . htmlspecialchars($header['image']) ?>');">
        <h1><?= htmlspecialchars($header['description']) ?></h1>
    </header>
<?php endforeach; ?>
<main>
    <?php foreach ($introduction as $intro): ?>
        <section id="introduction">
            <p><?= $intro['description'] ?></p>
        </section>
    <?php endforeach; ?>


    <?php foreach ($information as $info): ?>
        <h2><?= $info['title'] ?></h2>
        <section class="tour-info">
            <div class="tickets">
                <div class="ticket">
                    <?php foreach ($regularTickets as $regularTicket): ?>
                        <h2><?= $regularTicket['title'] ?></h2>
                        <p><?= $regularTicket['description'] ?></p>
                    <?php endforeach; ?>
                </div>
                <div class="ticket">
                    <?php foreach ($familyTickets as $familyTicket): ?>
                        <h2><?= $familyTicket['title'] ?></h2>
                        <p><?= $familyTicket['description'] ?></p>
                    <?php endforeach; ?>
                </div>
                <a href="/history/addTicket" id="buy-button">
                    Buy Tickets
                </a>
            </div>
            <div class="details">
                <p><?= $info['description'] ?></p>
            </div>
        </section>
    <?php endforeach; ?>

    <?php include __DIR__ . '/locationCarousel.php' ?>

    <?php foreach ($routes as $route): ?>
        <h2><?= htmlspecialchars($route['title']) ?></h2>
        <section class="tour-route">
            <div class="destinations">
                <ul>
                    <?php
                    $items = explode("\n", $route['description']);
                    foreach ($items as $item): ?>
                        <li><?= htmlspecialchars(trim($item)) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="img-wrapper">
                <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d77933.06515108632!2d4.5549343!3d52.3811485!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ef6bc1e32bc7%3A0x9b4f9d18ffe7688!2sSt.-Bavokerk%2C%20Grote%20Markt%2022%2C%202011%20RD%20Haarlem!5e0!3m2!1sen!2snl!4v1718933853173!5m2!1sen!2snl" width="800" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
            </div>
        </section>
    <?php endforeach; ?>





</main>

<?php include __DIR__ . '/../inc/footer.php'; ?>
