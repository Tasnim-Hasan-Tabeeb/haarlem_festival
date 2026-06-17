<?php include __DIR__ . '/../inc/header.php'; ?>

<?php $danceCssVersion = filemtime(__DIR__ . '/../../../public/frontend/css/dance.css'); ?>
<link rel="stylesheet" href="/frontend/css/dance.css?v=<?= $danceCssVersion ?>" />

<main class="dance-page">
<!-- ── HERO ───────────────────────────────────────────────── -->
<div id="section-dance">
    <div class="dance-image">
        <img src="/images/overview/dance.webp" alt="DANCE!">
        <div class="dance-image__content">
            <h1>DANCE!</h1>
            <p>Live sets, unforgettable artists and Haarlem's best dance venues.</p>
            <a href="#dance-tickets">View tickets</a>
        </div>
    </div>
</div>

<!-- ── ARTISTS ────────────────────────────────────────────── -->
<div class="section-2">
    <h2 class="artist-list">Our Artists</h2>
    <div class="artists-container">
        <?php foreach ($artists as $artist): ?>
            <div class="artist-containers">
                <div class="artist">
                    <a href="/dance/artists?id=<?= $artist['artist_id']; ?>">
                        <div class="artist-image">
                            <img src="<?= htmlspecialchars($artist['image_url']) ?>"
                                 alt="<?= htmlspecialchars($artist['artist_name']); ?>" />
                        </div>
                        <div class="artist-name"><?= htmlspecialchars($artist['artist_name']); ?></div>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ── VENUES ─────────────────────────────────────────────── -->
<div class="section-3">
    <h2 class="venue-list">Our Locations</h2>
    <div class="venues-container">
        <?php foreach ($venues as $venue): ?>
            <div class="venue"
                 data-name="<?= htmlspecialchars($venue['venue_name']); ?>"
                 data-location="<?= htmlspecialchars($venue['venue_location']); ?>"
                 data-map="<?= htmlspecialchars($venue['map_url']); ?>">
                <div class="venue-image">
                    <img src="<?= htmlspecialchars($venue['venue_image']) ?>"
                         alt="<?= htmlspecialchars($venue['venue_name']); ?>" />
                </div>
                <div class="venue-name"><?= htmlspecialchars($venue['venue_name']); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ── VENUE MODAL (custom, no Bootstrap) ─────────────────── -->
<div class="venue-modal-overlay" id="venueModal" role="dialog" aria-modal="true" aria-label="Venue Details">
    <div class="venue-modal">
        <div class="venue-modal__header">
            <h5>Venue Details</h5>
            <button class="venue-modal__close" id="closeVenueModal" aria-label="Close">✕</button>
        </div>
        <div class="venue-modal__body">
            <h2 id="venue-detail-name"></h2>
            <p  id="venue-detail-location"></p>
            <iframe id="venue-map" allowfullscreen loading="lazy"></iframe>
        </div>
    </div>
</div>

<?php require __DIR__ . '/tickets.php'; ?>
</main>

<!-- ── TOAST ──────────────────────────────────────────────── -->
<div class="dance-toast" id="danceToast"></div>

<?php include __DIR__ . '/../inc/footer.php'; ?>

<?php $danceJsVersion = filemtime(__DIR__ . '/../../../public/frontend/js/dance.js'); ?>
<script src="/frontend/js/dance.js?v=<?= $danceJsVersion ?>"></script>
