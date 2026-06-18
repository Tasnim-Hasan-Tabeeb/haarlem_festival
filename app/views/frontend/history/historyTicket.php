<?php include __DIR__ . '/../inc/header.php'; ?>

<link rel="stylesheet" href="/frontend/css/ticket.css" />

<div class="history-page">
    <div class="history-container">

        <!-- ── HEADER ─────────────────────────────────────── -->
        <div class="history-header">
            <h1>A Stroll Through History</h1>
            <p>Embark on your Haarlem journey with just a few clicks</p>
        </div>

        <!-- ── STEP 1: Language ───────────────────────────── -->
        <div class="history-card">
            <p class="history-card__label">1 — Select Language</p>
            <div id="languages" class="languages"
                 data-languages='<?php echo json_encode($tours); ?>'>
                <!-- populated by JS -->
            </div>
        </div>

        <!-- ── STEP 2: Date & Time ────────────────────────── -->
        <div class="history-card">
            <p class="history-card__label">2 — Select Date &amp; Time</p>
            <div id="timetable" class="timetable">
                <!-- populated by JS -->
            </div>
        </div>

        <!-- ── STEP 3: Participants ───────────────────────── -->
        <div class="history-card">
            <p class="history-card__label">3 — Select Ticket Type &amp; Participants</p>
            <div class="ticket-options">

                <!-- Regular -->
                <label class="ticket-option">
                    <input type="radio" id="regular" name="ticketType" value="regular" />
                    <div class="ticket-option__label">
                        Regular Participant
                        <span class="ticket-option__desc"> — €17.50 per person</span>
                    </div>
                    <div class="participant-count">
                        <input type="number" id="regularParticipants" min="0" value="0" />
                    </div>
                </label>

                <!-- Family -->
                <label class="ticket-option">
                    <input type="radio" id="family" name="ticketType" value="family" />
                    <div class="ticket-option__label">
                        Family Ticket
                        <span class="ticket-option__desc"> — fixed price €60.00</span>
                    </div>
                </label>

            </div>
        </div>

        <!-- ── TOTAL ──────────────────────────────────────── -->
        <div class="history-total">
            <span class="history-total__label">Total</span>
            <span class="history-total__amount">€<span id="total">0.00</span></span>
        </div>

        <!-- ── ACTIONS ────────────────────────────────────── -->
        <div class="history-actions">
            <button class="btn-primary" id="addToCartButton">Add to Cart</button>
        </div>

        <!-- ── MESSAGE ────────────────────────────────────── -->
        <div id="message"></div>

    </div>
</div>

<div id="pageLoader" class="page-loader">
    <div class="loader-spinner"></div>
    <p>Adding to cart...</p>
</div>

<?php $historyTicketJsVersion = filemtime(__DIR__ . '/../../../public/frontend/js/history-ticket.js'); ?>
<script src="/frontend/js/history-ticket.js?v=<?= $historyTicketJsVersion ?>"></script>
<?php include __DIR__ . '/../inc/footer.php'; ?>
