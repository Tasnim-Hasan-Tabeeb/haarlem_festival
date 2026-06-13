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
            <p>Three days of live sets, unforgettable artists and Haarlem's best dance venues.</p>
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

<!-- ── DAY 1 ──────────────────────────────────────────────── -->
<section class="dance-tickets" id="dance-tickets">
<div class="dance-tickets__heading">
    <h2>Tickets</h2>
    <p>Choose a day pass or reserve a spot for an individual performance.</p>
</div>

<div class="section-4a dance-day">
    <h3 class="ticket-list">Day 1 <span>Friday</span></h3>

    <div class="passes-container">
        <?php foreach ($allAccessPass as $pass): ?>
            <?= renderPass($pass) ?>
        <?php endforeach; ?>
        <?php foreach ($fridayPass as $pass): ?>
            <?= renderPass($pass) ?>
        <?php endforeach; ?>
    </div>

    <div class="tickets-container">
        <?php foreach ($fridayTickets as $ticket): ?>
            <?= renderTicket($ticket) ?>
        <?php endforeach; ?>
        <?php if (empty($fridayTickets)): ?>
            <p class="no-data">No tickets available for Day 1.</p>
        <?php endif; ?>
    </div>
</div>

<!-- ── DAY 2 ──────────────────────────────────────────────── -->
<div class="section-4b dance-day">
    <h3 class="ticket-list">Day 2 <span>Saturday</span></h3>

    <div class="passes-container">
        <?php foreach ($allAccessPass as $pass): ?>
            <?= renderPass($pass) ?>
        <?php endforeach; ?>
        <?php foreach ($saturdayPass as $pass): ?>
            <?= renderPass($pass) ?>
        <?php endforeach; ?>
    </div>

    <div class="tickets-container">
        <?php foreach ($saturdayTickets as $ticket): ?>
            <?= renderTicket($ticket) ?>
        <?php endforeach; ?>
        <?php if (empty($saturdayTickets)): ?>
            <p class="no-data">No tickets available for Day 2.</p>
        <?php endif; ?>
    </div>
</div>

<!-- ── DAY 3 ──────────────────────────────────────────────── -->
<div class="section-4c dance-day">
    <h3 class="ticket-list">Day 3 <span>Sunday</span></h3>

    <div class="passes-container">
        <?php foreach ($allAccessPass as $pass): ?>
            <?= renderPass($pass) ?>
        <?php endforeach; ?>
        <?php foreach ($sundayPass as $pass): ?>
            <?= renderPass($pass) ?>
        <?php endforeach; ?>
    </div>

    <div class="tickets-container">
        <?php foreach ($sundayTickets as $ticket): ?>
            <?= renderTicket($ticket) ?>
        <?php endforeach; ?>
        <?php if (empty($sundayTickets)): ?>
            <p class="no-data">No tickets available for Day 3.</p>
        <?php endif; ?>
    </div>
</div>
</section>
</main>

<!-- ── TOAST ──────────────────────────────────────────────── -->
<div class="dance-toast" id="danceToast"></div>

<?php include __DIR__ . '/../inc/footer.php'; ?>

<?php
/* ── PHP HELPERS ─────────────────────────────────────────── */
function renderPass(array $pass): string {
    return '
    <div class="pass-container">
        <div class="top-section">
            <p class="pass-name">' . htmlspecialchars($pass['passName']) . '</p>
        </div>
        <div class="bottom-section">
            <div class="pass-details">
                <p class="pass-description">' . htmlspecialchars($pass['passDescription']) . '</p>
                <p class="pass-price">€' . htmlspecialchars($pass['passPrice']) . '</p>
            </div>
            <button class="buy-pass-button" data-passtype="' . htmlspecialchars($pass['passType']) . '">Add to cart</button>
        </div>
    </div>';
}

function renderTicket(array $ticket): string {
    $imgSrc = strpos($ticket['music_event_image'], '/') === 0
        ? $ticket['music_event_image']
        :  $ticket['music_event_image'];

    return '
    <div class="ticket-container">
        <div class="ticket">
            <div class="ticket-image">
                <img src="' . htmlspecialchars($imgSrc) . '" alt="' . htmlspecialchars($ticket['event_name']) . '" />
            </div>
            <div class="ticket-details">
                <h2>' . htmlspecialchars($ticket['event_name']) . '</h2>
                <div class="ticket-info">
                    <p><strong>Location:</strong> ' . htmlspecialchars($ticket['venue_name']) . '</p>
                    <p><strong>Duration:</strong> ' . htmlspecialchars($ticket['event_duration']) . ' min</p>
                    <p><strong>Date &amp; Time:</strong> ' . htmlspecialchars($ticket['event_date']) . ' ' . htmlspecialchars($ticket['event_start_time']) . '</p>
                    <p><strong>Session:</strong> ' . htmlspecialchars($ticket['session_type']) . '</p>
                    <p><strong>Price:</strong> €' . htmlspecialchars($ticket['event_price']) . '</p>
                </div>
            </div>
            <input type="hidden" class="music-performance-id" value="' . htmlspecialchars($ticket['music_performance_id']) . '" />
            <div class="ticket-buttons">
                <button class="buy-button">Add To Cart</button>
            </div>
        </div>
    </div>';
}
?>

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
        const passType = $(this).data('passtype');

        $.ajax({
            url: '/dance/addpasstobasket',
            method: 'POST',
            data: { pass_type: passType },
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
