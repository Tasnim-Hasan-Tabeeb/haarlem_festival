<?php include __DIR__ . '/../inc/header.php'; ?>

<link rel="stylesheet" href="/frontend/css/artist.css" />

<div class="artist-page">

    <!-- ── HERO ───────────────────────────────────────────── -->
    <div id="section-artist">
        <div class="artist-header">
            <div class="artist-header-image">
                <img src="<?= htmlspecialchars($artists['detail_image']) ?>"
                     alt="<?= htmlspecialchars($artists['artist_name']); ?>" />
            </div>
            <h1><?= htmlspecialchars($artists['artist_name']); ?></h1>
        </div>
    </div>

    <!-- ── MAIN GRID: profile | about | concerts ──────────── -->
    <div class="grid-container">

        <!-- Profile card -->
        <div class="section-1">
            <div class="artist">
                <div class="artist-image">
                    <img src="<?= htmlspecialchars($artists['image_url']) ?>"
                         alt="<?= htmlspecialchars($artists['artist_name']); ?>" />
                </div>
                <ul>
                    <li class="name"><?= htmlspecialchars($artists['artist_name']); ?></li>
                    <li><strong>Name:</strong> <?= htmlspecialchars($artists['artist_real_name']); ?></li>
                    <li><strong>Age:</strong> <?= htmlspecialchars($artists['age']); ?></li>
                    <li><strong>Nationality:</strong> <?= htmlspecialchars($artists['nationality']); ?></li>
                    <li><strong>Genre:</strong> <?= htmlspecialchars($artists['genre']); ?></li>
                </ul>
            </div>
        </div>

        <!-- About -->
        <div class="section-2">
            <div class="artist-aboutMe">
                <h2 class="artist-heading">About Me</h2>
                <p><?= htmlspecialchars($artists['about']); ?></p>
            </div>
        </div>

        <!-- Concerts -->
        <div class="section-3">
            <div class="artist-Conterts">
                <h2 class="artist-heading">Concerts</h2>

                <?php if (!empty($artistEvents)): ?>
                    <?php foreach ($artistEvents as $event): ?>
                        <div class="container">
                            <p class="event-date">
                                <?= htmlspecialchars($event['event_date']); ?>
                                &nbsp;·&nbsp;
                                <?= htmlspecialchars($event['event_start_time']); ?>
                                &nbsp;@&nbsp;
                                <?= htmlspecialchars($event['venue_name']); ?>
                                &nbsp;·&nbsp;
                                <strong>€<?= htmlspecialchars($event['event_price']); ?></strong>
                            </p>
                            <input type="hidden" class="music-performance-id"
                                   value="<?= htmlspecialchars($event['music_performance_id']); ?>" />
                            <button class="buyTicket-button">Buy Ticket</button>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p  class="no-data">No upcoming concerts.</p>
                <?php endif; ?>
            </div>
        </div>

    </div>

    <!-- ── ALBUMS ──────────────────────────────────────────── -->
    <div class="section-4">
        <h2 class="artist-heading">Best Albums</h2>
        <div class="artist-albums">
            <?php foreach ($artistAlbums as $album): ?>
                <div class="album-container">
                    <div class="album-image">
                        <img src="<?= htmlspecialchars($album['image_url']) ?>"
                             alt="<?= htmlspecialchars($album['album_name']); ?>" />
                    </div>
                    <div class="album-info">
                        <?= htmlspecialchars($album['album_name']); ?>
                        <br />
                        <span class="album-year">
                            <?= htmlspecialchars($album['year']); ?>
                        </span>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- ── MUSIC ───────────────────────────────────────────── -->
    <div class="section-5">
        <div class="artist-songs">
            <h2 class="artist-heading"><?= htmlspecialchars($artists['artist_name']); ?>'s Music</h2>

            <?php if (!empty($artistMusic)): ?>
                <?php foreach ($artistMusic as $music): ?>
                    <div class="song-container">
                        <div class="song-info">
                            <div class="song-name"><?= htmlspecialchars($music['music_title']); ?></div>
                            <div class="music-player">
                                <audio controls preload="none">
                                    <source src="/music/<?= htmlspecialchars($music['music_url']); ?>" type="audio/mpeg" />
                                    Your browser does not support the audio element.
                                </audio>
                            </div>
                            <div class="song-image">
                                <img src="<?= htmlspecialchars($music['image_url']) ?>"
                                     alt="<?= htmlspecialchars($music['music_title']); ?>" />
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-data">No music available.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- ── BACK ────────────────────────────────────────────── -->
   

</div>

<!-- ── TOAST ──────────────────────────────────────────────── -->
<div class="artist-toast" id="artistToast"></div>

<?php include __DIR__ . '/../inc/footer.php'; ?>

<script>
$(document).ready(function () {

    /* ── toast helper ───────────────────────────────────────── */
    function showToast(msg, type = 'success') {
        const $t = $('#artistToast');
        $t.text(msg).removeClass('success error').addClass(type + ' show');
        setTimeout(() => $t.removeClass('show'), 3000);
    }

    /* ── buy ticket ─────────────────────────────────────────── */
    $('.buyTicket-button').on('click', function (e) {
        e.preventDefault();
        const id = $(this).closest('.container').find('.music-performance-id').val();

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

    /* ── favourite toggle (local) ───────────────────────────── */
    $('.favorite-button').on('click', function () {
        const active = $(this).hasClass('active');
        $(this).toggleClass('active');
        showToast(active ? 'Removed from favourites.' : 'Added to favourites!', 'success');
    });

});
</script>

