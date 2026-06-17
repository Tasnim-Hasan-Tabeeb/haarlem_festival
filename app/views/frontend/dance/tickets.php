<?php
$renderPass = static function (array $pass): string {
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
            <button class="buy-pass-button" data-pass-id="' . (int) $pass['pass_id'] . '">Add to cart</button>
        </div>
    </div>';
};

$renderTicket = static function (array $ticket): string {
    return '
    <div class="ticket-container">
        <div class="ticket">
            <div class="ticket-image">
                <img src="' . htmlspecialchars($ticket['music_event_image']) . '" alt="' . htmlspecialchars($ticket['event_name']) . '" />
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
            <input type="hidden" class="music-performance-id" value="' . (int) $ticket['music_performance_id'] . '" />
            <div class="ticket-buttons">
                <button class="buy-button">Add To Cart</button>
            </div>
        </div>
    </div>';
};
?>

<section class="dance-tickets" id="dance-tickets">
    <div class="dance-tickets__heading">
        <h2>Tickets</h2>
        <p>Choose a day pass or reserve a spot for an individual performance.</p>
    </div>

    <?php if (empty($danceSchedule)): ?>
        <p class="no-data">No dance performances are currently available.</p>
    <?php endif; ?>

    <?php foreach ($danceSchedule as $index => $day): ?>
        <div class="dance-day">
            <h3 class="ticket-list">
                Day <?= $index + 1 ?>
                <span><?= htmlspecialchars($day['weekday'] . ' ' . $day['formattedDate']) ?></span>
            </h3>

            <?php if ($day['dayPass'] !== null): ?>
                <div class="passes-container">
                    <?= $renderPass($day['dayPass']) ?>
                </div>
            <?php endif; ?>

            <div class="tickets-container">
                <?php foreach ($day['tickets'] as $ticket): ?>
                    <?= $renderTicket($ticket) ?>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>

    <?php if ($allDatesPass !== null): ?>
        <div class="dance-day dance-all-dates">
            <h3 class="ticket-list">All Dates <span>Every current dance date</span></h3>
            <div class="passes-container">
                <?= $renderPass($allDatesPass) ?>
            </div>
        </div>
    <?php endif; ?>
</section>
