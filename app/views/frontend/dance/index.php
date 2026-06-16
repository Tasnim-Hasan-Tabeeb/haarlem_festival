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

<script>
$(document).ready(function () {

    /* ── VENUE MODAL ──────────────────────────────────────── */
    $('.venue').on('click', function () {
        const name     = $(this).data('name');
        const location = $(this).data('location');
        const mapUrl   = $(this).data('map');

  
        $('#venue-detail-name').text(name);
        $('#venue-detail-location').text(location);
        $('#venue-map').attr('src', mapUrl);
        $('#venueModal').addClass('open');
        $('body').css('overflow', 'hidden');
    });

    $('#closeVenueModal, #venueModal').on('click', function (e) {
        if (e.target === this) {
            $('#venueModal').removeClass('open');
            $('#venue-map').attr('src', ''); // stop map loading
            $('body').css('overflow', '');
        }
    });

    $(document).on('keydown', function (e) {
        if (e.key === 'Escape') {
            $('#venueModal').removeClass('open');
            $('#venue-map').attr('src', '');
            $('body').css('overflow', '');
        }
    });

    /* ── TOAST ────────────────────────────────────────────── */
    function showToast(message, type = 'success') {
        const $t = $('#danceToast');
        $t.text(message).removeClass('success error').addClass(type).addClass('show');
        setTimeout(() => $t.removeClass('show'), 3000);
    }

    /* ── BUY TICKET ───────────────────────────────────────── */
    $(document).on('click', '.buy-button', function (e) {
        e.preventDefault();
        const id = $(this).closest('.ticket-container').find('.music-performance-id').val();

        $.ajax({
            url: '/dance/create',
            method: 'POST',
            data: { music_performance_id: id },
            success: function () {
                $('.cart-counter').removeClass('d-none');
                let counter = $('.cart-counter').text() || 0;
                counter = parseInt(counter);

                counter += 1;
                $('.cart-counter').text(counter);
                
                toastr.success('Ticket added to cart!'); 
          },
            error:   function () { toastr.error('Failed to add ticket. Try again.'); }
        });
    });

    /* ── BUY PASS ─────────────────────────────────────────── */
    $(document).on('click', '.buy-pass-button', function (e) {
        e.preventDefault();
        const passId = $(this).data('pass-id');

        $.ajax({
            url: '/dance/addpasstobasket',
            method: 'POST',
            data: { pass_id: passId },
            success: function () {
                $('.cart-counter').removeClass('d-none');
                let counter = $('.cart-counter').text() || 0;
                counter = parseInt(counter);

                counter += 1;
                $('.cart-counter').text(counter);
                toastr.success('Pass added to cart!'); 
            },
            error:   function () { toastr.error('Failed to add pass. Try again.'); }
        });
    });

    /* ── FAVOURITE (local toggle) ─────────────────────────── */
    $(document).on('click', '.favorite-button', function () {
        const $img = $(this).find('img');
        const isFav = $(this).hasClass('active');
        $(this).toggleClass('active');
        showToast(isFav ? 'Removed from favourites.' : 'Added to favourites!', 'success');
    });

});
</script>
