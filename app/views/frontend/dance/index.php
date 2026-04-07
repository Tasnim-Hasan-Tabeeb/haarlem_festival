<?php include __DIR__ . '/../inc/header.php'; ?>

<link rel="stylesheet" href="/frontend/css/dance.css"/>

<title>Dance</title>
<link rel="stylesheet" href="/frontend/css/dance.css">
<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

</head>
<body>
<div id="section-dance">
    <div class="dance-image">
        <img src="/images/dance-head.jpg" alt="DANCE!">
        <h1>DANCE!</h1>
    </div>
</div>

<div class="section-2">
    <h2 class="artist-list">Our Artists</h2>
    <div class="artists-container">
        <?php foreach ($artists as $artist): ?>
            <div class="artist-containers">
                <div class="artist">
                    <a href="/dance/artists?id=<?= $artist['artist_id']; ?>">
                        <div class="artist-image">
                            <img src="<?= '/images/' . $artist['image_url'] ?>" alt="<?= $artist['artist_name']; ?>">
                        </div>
                        <div class="artist-name"><?= $artist['artist_name']; ?></div>
                    </a>
                </div>
                <div class="background-rectangle"></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="section-3">
    <h2 class="venue-list">Our Locations</h2>
    <div class="venues-container">
        <?php foreach ($venues as $venue) :?>
            <div class="venue" data-toggle="modal" data-target="#venueModal"
                 data-name="<?= htmlspecialchars($venue['venue_name']); ?>"
                 data-location="<?= htmlspecialchars($venue['venue_location']); ?>"
                 data-map="<?= htmlspecialchars($venue['map_url']); ?>">
                <div class="venue-image">
                    <img src="<?= '/images/' . htmlspecialchars($venue['venue_image']) ?>" alt="<?= htmlspecialchars($venue['venue_name']); ?>">
                </div>
                <div class="venue-name"><?= htmlspecialchars($venue['venue_name']); ?></div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="modal fade" id="venueModal" tabindex="-1" role="dialog" aria-labelledby="venueModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title details-venue" id="venueModalLabel">Venue Details</h5>
                <!-- Removed the close button from here -->
            </div>
            <div class="modal-body">
                <h2 id="venue-detail-name"></h2>
                <p id="venue-detail-location"></p>
                <div class="map">
                    <iframe id="venue-map" width="100%" height="400" frameborder="0" style="border:0" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-close" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<div class="section-4a">
    <h2 class="ticket-list">Tickets</h2>
    <h2 class="ticket-list">DANCE! - DAY 1</h2>
    <div class="passes-container">
        <?php foreach ($allAccessPass as $pass): ?>
            <div class="pass-container">
                <div class="top-section">
                    <p class="pass-name"><?= $pass['passName']; ?></p>
                </div>
                <div class="bottom-section">
                    <p class="pass-description-price"><?= $pass['passDescription']; ?> - €<?= $pass['passPrice']; ?></p>
                    <button class="buy-pass-button" data-passType="<?= $pass['passType']; ?>">Buy</button>
                </div>
            </div>
        <?php endforeach; ?>
        <?php foreach ($fridayPass as $pass): ?>
            <div class="pass-container">
                <div class="top-section">
                    <p class="pass-name"><?= $pass['passName']; ?></p>
                </div>
                <div class="bottom-section">
                    <p class="pass-description-price"><?= $pass['passDescription']; ?> - €<?= $pass['passPrice']; ?></p>
                    <button class="buy-pass-button" data-passType="<?= $pass['passType']; ?>">Buy</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="tickets-container">
        <?php foreach ($fridayTickets as $ticket): ?>
            <div class="ticket-container">
                <div class="ticket">
                    <div class="ticket-image">
                        <img src="<?= '/images/' . $ticket['music_event_image'] ?>" alt="<?= $ticket['event_name']; ?>">
                    </div>
                    <div class="ticket-details">
                        <h2><?= $ticket['event_name']; ?></h2>
                        <div class="ticket-info">
                            <p><strong>Location:</strong> <?= $ticket['venue_name']; ?></p>
                            <p><strong>Duration:</strong> <?= $ticket['event_duration']; ?></p>
                            <p><strong>Date & Time:</strong> <?= $ticket['event_date']; ?> <?= $ticket['event_start_time']; ?></p>
                            <p><strong>Session:</strong> <?= $ticket['session_type']; ?></p>
                            <p><strong>Price:</strong> €<?= $ticket['event_price']; ?></p>
                        </div>
                    </div>
                    <input type="hidden" class="music-performance-id" value="<?= $ticket['music_performance_id']; ?>">
                    <div class="ticket-buttons">
                        <button class="favorite-button"><img src="/images/heart.png" alt="Favorite"></button>
                        <button class="buy-button">Buy</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="section-4b">
    <h2 class="ticket-list">DANCE! - DAY 2</h2>
    <div class="passes-container">
        <?php foreach ($allAccessPass as $pass): ?>
            <div class="pass-container">
                <div class="top-section">
                    <p class="pass-name"><?= $pass['passName']; ?></p>
                </div>
                <div class="bottom-section">
                    <p class="pass-description-price"><?= $pass['passDescription']; ?> - €<?= $pass['passPrice']; ?></p>
                    <button class="buy-pass-button" data-passType="<?= $pass['passType']; ?>">Buy</button>
                </div>
            </div>
        <?php endforeach; ?>
        <?php foreach ($saturdayPass as $pass): ?>
            <div class="pass-container">
                <div class="top-section">
                    <p class="pass-name"><?= $pass['passName']; ?></p>
                </div>
                <div class="bottom-section">
                    <p class="pass-description-price"><?= $pass['passDescription']; ?> - €<?= $pass['passPrice']; ?></p>
                    <button class="buy-pass-button" data-passType="<?= $pass['passType']; ?>">Buy</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="tickets-container">
        <?php foreach ($saturdayTickets as $ticket): ?>
            <div class="ticket-container">
                <div class="ticket">
                    <div class="ticket-image">
                        <img src="<?= '/images/' . $ticket['music_event_image'] ?>" alt="<?= $ticket['event_name']; ?>">
                    </div>
                    <div class="ticket-details">
                        <h2><?= $ticket['event_name']; ?></h2>
                        <div class="ticket-info">
                            <p><strong>Location:</strong> <?= $ticket['venue_name']; ?></p>
                            <p><strong>Duration:</strong> <?= $ticket['event_duration']; ?></p>
                            <p><strong>Date & Time:</strong> <?= $ticket['event_date']; ?> <?= $ticket['event_start_time']; ?></p>
                            <p><strong>Session:</strong> <?= $ticket['session_type']; ?></p>
                            <p><strong>Price:</strong> €<?= $ticket['event_price']; ?></p>
                        </div>
                    </div>
                    <input type="hidden" class="music-performance-id" value="<?= $ticket['music_performance_id']; ?>">
                    <div class="ticket-buttons">
                        <button class="favorite-button"><img src="/images/heart.png" alt="Favorite"></button>
                        <button class="buy-button">Buy</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<div class="section-4c">
    <h2 class="ticket-list">DANCE! - DAY 3</h2>
    <div class="passes-container">
        <?php foreach ($allAccessPass as $pass): ?>
            <div class="pass-container">
                <div class="top-section">
                    <p class="pass-name"><?= $pass['passName']; ?></p>
                </div>
                <div class="bottom-section">
                    <p class="pass-description-price"><?= $pass['passDescription']; ?> - €<?= $pass['passPrice']; ?></p>
                    <button class="buy-pass-button" data-passType="<?= $pass['passType']; ?>">Buy</button>
                </div>
            </div>
        <?php endforeach; ?>
        <?php foreach ($sundayPass as $pass): ?>
            <div class="pass-container">
                <div class="top-section">
                    <p class="pass-name"><?= $pass['passName']; ?></p>
                </div>
                <div class="bottom-section">
                    <p class="pass-description-price"><?= $pass['passDescription']; ?> - €<?= $pass['passPrice']; ?></p>
                    <button class="buy-pass-button" data-passType="<?= $pass['passType']; ?>">Buy</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
    <div class="tickets-container">
        <?php foreach ($SundayTickets as $ticket): ?>
            <div class="ticket-container">
                <div class="ticket">
                    <div class="ticket-image">
                        <img src="<?= '/images/' . $ticket['music_event_image'] ?>" alt="<?= $ticket['event_name']; ?>">
                    </div>
                    <div class="ticket-details">
                        <h2><?= $ticket['event_name']; ?></h2>
                        <div class="ticket-info">
                            <p><strong>Location:</strong> <?= $ticket['venue_name']; ?></p>
                            <p><strong>Duration:</strong> <?= $ticket['event_duration']; ?></p>
                            <p><strong>Date & Time:</strong> <?= $ticket['event_date']; ?> <?= $ticket['event_start_time']; ?></p>
                            <p><strong>Session:</strong> <?= $ticket['session_type']; ?></p>
                            <p><strong>Price:</strong> €<?= $ticket['event_price']; ?></p>
                        </div>
                    </div>
                    <input type="hidden" class="music-performance-id" value="<?= $ticket['music_performance_id']; ?>">
                    <div class="ticket-buttons">
                        <button class="favorite-button"><img src="/images/heart.png" alt="Favorite"></button>
                        <button class="buy-button">Buy</button>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('#venueModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); // Button that triggered the modal
            var name = button.data('name'); // Extract info from data-* attributes
            var location = button.data('location');
            var mapUrl = button.data('map');

            var modal = $(this);
            modal.find('#venue-detail-name').text(name);
            modal.find('#venue-detail-location').text(location);
            modal.find('#venue-map').attr('src', mapUrl);
        });
    });

    $(document).ready(function() {
        // Handle click on event ticket buy buttons
        $('.buy-button').click(function(event) {
            event.preventDefault();
            var ticketContainer = $(this).closest('.ticket-container');
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

        // Handle click on pass buy buttons
        $('.buy-pass-button').click(function(event) {
            event.preventDefault();
            var passType = $(this).data('passtype'); // Correct attribute name to 'data-passtype'

            $.ajax({
                url: '/dance/addpasstobasket',
                method: 'POST',
                data: {
                    pass_type: passType
                },
                success: function(response) {
                    alert('Pass added to basket successfully!');
                },
                error: function(xhr, status, error) {
                    alert('Failed to add pass to basket. Please try again later.');
                }
            });
        });
    });


</script>


<?php include __DIR__ . '/../inc/footer.php'; ?>
</body>
</html>
