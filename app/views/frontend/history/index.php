<?php include __DIR__ . '/../inc/header.php'; ?>

<style>
    *, *::before, *::after {
        box-sizing: border-box;
    }

    .white-space {
        height: 80px;
    }

    /* ── Masthead ── */
    .masthead {
        position: relative;
        width: 100%;
        height: 380px;
        background-size: cover;
        background-position: center;
        border-radius: 12px;
        overflow: hidden;
        display: flex;
        align-items: flex-end;
        margin-bottom: 2.5rem;
    }

    .masthead::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.65) 0%, transparent 60%);
    }

    .masthead h1 {
        position: relative;
        z-index: 1;
        color: #fff;
        font-size: 2.2rem;
        font-weight: 500;
        padding: 2rem 2.5rem;
        margin: 0;
    }

    /* ── Main container ── */
    main {
        max-width: 1060px;
        margin: 0 auto;
        padding: 0 1.5rem 4rem;
    }

    /* ── Introduction ── */
    #introduction {
        padding: 0 0 2rem;
        margin-bottom: 2.5rem;
        border-bottom: 0.5px solid #ddd;
    }

    #introduction p {
        font-size: 1.05rem;
        line-height: 1.85;
        color: #444;
        max-width: 780px;
    }

    /* ── Section headings ── */
    main > h2 {
        font-size: 1.4rem;
        font-weight: 500;
        color: #111;
        margin-bottom: 1.25rem;
    }

    /* ── Tour info: tickets + details side by side ── */
    .tour-info {
        display: flex;
        flex-direction: row;
        gap: 2.5rem;
        align-items: flex-start;
        margin-bottom: 3.5rem;
    }

    .tickets {
        flex: 0 0 280px;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .ticket {
        background: #f7f7f7;
        border: 0.5px solid #ddd;
        border-radius: 10px;
        padding: 1.25rem;
    }

    .ticket h2 {
        font-size: 1rem;
        font-weight: 500;
        color: #111;
        margin: 0 0 0.4rem;
    }

    .ticket p {
        font-size: 0.875rem;
        color: #555;
        line-height: 1.65;
        margin: 0;
    }

    #buy-button {
        display: block;
        text-align: center;
        background: #1a1a1a;
        color: #fff;
        padding: 0.8rem 1rem;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 500;
        margin-top: 0.5rem;
        transition: background 0.15s;
    }

    #buy-button:hover {
        background: #333;
    }

    .details {
        flex: 1;
        font-size: 0.97rem;
        line-height: 1.85;
        color: #444;
    }

    /* ── Carousel section ── */
    .carousel-body {
        margin-bottom: 3.5rem;
    }

    .details img {
    width: 100%;
    max-width: 100%;
    height: 260px;
    object-fit: cover;
    border-radius: 10px;
    margin-top: 1.25rem;
    display: block;
    margin-bottom: 1.25rem;
}

    /* ── Tour route: list + map side by side ── */
    .tour-route {
        display: flex;
        flex-direction: row;
        gap: 2rem;
        align-items: flex-start;
        margin-top: 1.25rem;
        margin-bottom: 3rem;
    }

    .destinations {
        flex: 0 0 220px;
    }

    .destinations ul {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: 8px;
    }

    .destinations li {
        padding: 0.65rem 1rem;
        background: #f4f4f4;
        border-left: 3px solid #888;
        border-radius: 0 8px 8px 0;
        font-size: 0.9rem;
        color: #333;
        line-height: 1.4;
    }

    .img-wrapper {
        flex: 1;
        border-radius: 10px;
        overflow: hidden;
        border: 0.5px solid #ddd;
    }

    .img-wrapper iframe {
        display: block;
        width: 100%;
        height: 380px;
        border: 0;
    }

    /* ── Responsive ── */
    @media (max-width: 768px) {
        .tour-info,
        .tour-route {
            flex-direction: column;
        }

        .tickets {
            flex: none;
            width: 100%;
        }

        .destinations {
            flex: none;
            width: 100%;
        }

        .img-wrapper iframe {
            height: 260px;
        }

        .masthead {
            height: 260px;
        }

        .masthead h1 {
            font-size: 1.5rem;
            padding: 1.25rem 1.5rem;
        }
    }
</style>

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
                <a href="/history/addTicket" id="buy-button">Buy Tickets</a>
            </div>
           <div class="details">
                <img src="<?= '/images/' . htmlspecialchars($info['image']) ?>" alt="">
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
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d77933.06515108632!2d4.5549343!3d52.3811485!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c5ef6bc1e32bc7%3A0x9b4f9d18ffe7688!2sSt.-Bavokerk%2C%20Grote%20Markt%2022%2C%202011%20RD%20Haarlem!5e0!3m2!1sen!2snl!4v1718933853173!5m2!1sen!2snl"
                    allowfullscreen
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </section>

    <?php endforeach; ?>

</main>

<?php include __DIR__ . '/../inc/footer.php'; ?>