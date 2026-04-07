<?php include __DIR__ . '/../inc/header.php'; ?>
<link rel="stylesheet" href="/frontend/css/historyTicket.css" />

<div class="history-ticket-page">
    <div id="app">
        <h1>A Stroll Through History</h1>
        <p>EMBARK ON YOUR HAARLEM JOURNEY WITH JUST A FEW CLICKS</p>

        <div class="section">
            <label>Select Language:</label>
            <div id="languages" class="languages" data-languages='<?php echo json_encode($tours); ?>'>
            </div>
        </div>

        <div class="section">
            <label>Select Date and Time:</label>
            <div id="timetable" class="timetable">
            </div>
        </div>

        <div class="section">
            <label>Select number of Participants:</label>

            <div class="regularParticipants">
                <input type="radio" id="regular" name="ticketType" value="regular">
                <label for="regular">Regular Participant</label>
                <input type="number" id="regularParticipants" min="0" value="0">
            </div>

            <div class="familyParticipants">
                <input type="radio" id="family" name="ticketType" value="family">
                <label for="family">Family Ticket (fixed price €60)</label>
            </div>
        </div>

        <div class="section">
            <p>Total: € <span id="total">00.00</span></p>

            <div class="action-buttons">
                <button type="button" onclick="addToCart()">Add to Cart</button>
                <button type="button" onclick="addToWishList()">Add to Wish List</button>
            </div>
        </div>

        <div id="message"></div>
    </div>
</div>

<script src="/frontend/js/historyTicket.js"></script>