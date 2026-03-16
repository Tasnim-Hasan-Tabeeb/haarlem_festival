<?php include __DIR__ . '/../inc/header.php'; ?>

<title><?= htmlspecialchars($artists['artist_name']); ?></title>
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>

<link rel="stylesheet" href="/frontend/css/artist.css">
</head>
<body>

<div id="section-artist">
    <div class="artist-header">
        <div class="artist-header-image">
            <img src="<?= '/images/' . htmlspecialchars($artists['detail_image']) ?>" alt="<?= htmlspecialchars($artists['artist_name']); ?>">
        </div>
        <h1><?= htmlspecialchars($artists['artist_name']); ?></h1>
    </div>
</div>

<div class="grid-container">
    <div class="section-1">
        <div class="artist">
            <div class="artist-image">
                <img src="<?= '/images/' . htmlspecialchars($artists['image_url']) ?>" alt="<?= htmlspecialchars($artists['artist_name']); ?>">
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

    <div class="section-2">
        <div class="artist-aboutMe">
            <h2 class="artist-heading">About Me</h2>
            <p><?= htmlspecialchars($artists['about']); ?></p>
        </div>
    </div>

    <div class="section-3">
        <div class="artist-Conterts">
            <h2 class="artist-heading">Concerts</h2>
            <?php foreach ($artistEvents as $events): ?>
                <div class="container">
                    <p class="event-date"><?= htmlspecialchars($events['event_date']); ?> - <?= htmlspecialchars($events['event_start_time']); ?> @ <?= htmlspecialchars($events['venue_name']); ?> - €<?= htmlspecialchars($events['event_price']); ?></p>
                    <input type="hidden" class="music-performance-id" value="<?= htmlspecialchars($events['music_performance_id']); ?>">
                    <button class="favorite-button"><img src="/images/heart.png" alt="Favorite"></button>
                    <button class="buyTicket-button">Buy Ticket</button>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="section-4">
    <h2 class="artist-heading">Best Albums</h2>
    <div class="artist-albums">
        <?php foreach ($artistAlbums as $album): ?>
            <div class="album-container">
                <div class="album-image">
                    <img src="<?= '/images/' . htmlspecialchars($album['image_url']) ?>" alt="<?= htmlspecialchars($album['album_name']); ?>">
                </div>
                <div class="album-info"><?= htmlspecialchars($album['album_name']); ?> "<?= htmlspecialchars($album['year']); ?>"</div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="section-5">
    <div class="artist-songs">
        <h2 class="artist-heading"><?= htmlspecialchars($artists['artist_name']); ?>'s Music</h2>
        <?php foreach ($artistMusic as $music): ?>
            <div class="song-container">
                <div class="song-info">
                    <div class="song-name"><?= htmlspecialchars($music['music_title']); ?></div>
                    <div class="music-player">
                        <audio controls>
                            <source src="<?= '/music/' . htmlspecialchars($music['music_url']); ?>" type="audio/mpeg">
                            Your browser does not support the audio element.
                        </audio>
                    </div>
                    <div class="song-image">
                        <img src="<?= '/images/' . htmlspecialchars($music['image_url']) ?>" alt="<?= htmlspecialchars($music['music_title']); ?>">
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="section-6">
    <h2 class="artist-heading">Awards</h2>
    <div class="artist-awards">
        <?php foreach ($artistAwards as $awards): ?>
            <div class="award-container">
                <div class="awards-image">
                    <img src="<?= '/images/' . htmlspecialchars($awards['image_url']) ?>" alt="<?= htmlspecialchars($awards['title']); ?>">
                </div>
                <div class="award-title"><?= htmlspecialchars($awards['title']); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<a href="/dance" class="backButton">Back to Tickets Page</a>

<script>
    $(document).ready(function() {
        // Handle click on event ticket buy buttons
        $('.buyTicket-button').click(function(event) {
            event.preventDefault();
            var ticketContainer = $(this).closest('.container');
            var musicPerformanceId = ticketContainer.find('.music-performance-id').val();

            $.ajax({
                url: '/dance/create',
                method: 'POST',
                data: {
                    music_performance_id: musicPerformanceId
                },
                success: function(response) {
                    alert('Item added to basket successfully!');
                },
                error: function(xhr, status, error) {
                    alert('Failed to add item to basket. Please try again later.');
                }
            });
        });
    });
</script>

<?php include __DIR__ . '/../inc/footer.php'; ?>
</body>
</html>
