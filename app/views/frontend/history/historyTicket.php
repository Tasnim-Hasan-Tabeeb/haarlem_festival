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
            <button class="btn-primary"  onclick="addToCart()">Add to Cart</button>
        </div>

        <!-- ── MESSAGE ────────────────────────────────────── -->
        <div id="message"></div>

    </div>
</div>

<script>
    let selectedLanguage = null;
    let selectedDate     = null;
    let selectedTimeSlot = null;
    let regularParticipants = 0;

    document.addEventListener('DOMContentLoaded', function () {
        populateLanguages();
        attachEventListeners();
    });

    function attachEventListeners() {
        document.getElementById('regularParticipants').addEventListener('input', handleParticipantChange);
        document.getElementById('regular').addEventListener('change', handleTicketTypeChange);
        document.getElementById('family').addEventListener('change', handleTicketTypeChange);
    }

    function handleTicketTypeChange(event) {
        const numInput = document.getElementById('regularParticipants');
        if (event.target.value === 'family') {
            numInput.value = 0;
            numInput.disabled = true;
            regularParticipants = 0;
        } else {
            numInput.disabled = false;
        }
        calculateTotal();
    }

    function handleParticipantChange(event) {
        regularParticipants = parseInt(event.target.value) || 0;
        if (regularParticipants >= 4) {
            displayMessage('Tip: Buy a family ticket and save €10!', 'success');
        }
        calculateTotal();
    }

    function calculateTotal() {
        let total = 0;
        if (document.getElementById('regular').checked) {
            total = regularParticipants * 17.50;
        } else if (document.getElementById('family').checked) {
            total = 60;
        }
        document.getElementById('total').textContent = total.toFixed(2);
    }

    function populateLanguages() {
        const languagesDiv = document.getElementById('languages');
        const tours = JSON.parse(languagesDiv.getAttribute('data-languages'));

        const seen = new Set();
        tours.forEach(tour => {
            if (!seen.has(tour.name)) {
                seen.add(tour.name);
                const btn = document.createElement('button');
                btn.textContent = tour.name;
                btn.type = 'button';
                btn.onclick = () => {
                    selectedLanguage = tour.name;
                    highlightSelection(btn, 'languages');
                    fetchTours(tour.name);
                };
                languagesDiv.appendChild(btn);
            }
        });
    }

    function highlightSelection(selectedBtn, containerId) {
        document.getElementById(containerId)
            .querySelectorAll('button')
            .forEach(b => b.classList.remove('selected'));
        selectedBtn.classList.add('selected');
    }

    function fetchTours(language) {
        const url = `/history/getToursByLanguage?language_name=${encodeURIComponent(language)}`;
        fetch(url)
            .then(r => r.json())
            .then(data => {
                if (data.error) console.error('Error fetching tours:', data.error);
                else populateTimetable(data);
            })
            .catch(err => console.error('Error:', err));
    }

    function populateTimetable(tours) {
        const timetableDiv = document.getElementById('timetable');
        timetableDiv.innerHTML = '';

        const dates = [...new Set(tours.map(t => t.date))];

        dates.forEach(date => {
            const dateDiv = document.createElement('div');
            dateDiv.classList.add('date');

            const dateLabel = document.createElement('span');
            dateLabel.classList.add('date-label');
            dateLabel.textContent = date;
            dateDiv.appendChild(dateLabel);

            tours
                .filter(t => t.date === date && t.available_guides > 0)
                .forEach(tour => {
                    const btn = document.createElement('button');
                    btn.classList.add('timeslot');
                    btn.type = 'button';
                    btn.textContent = `${tour.start_time}–${tour.end_time}`;
                    btn.onclick = () => {
                        selectedDate     = date;
                        selectedTimeSlot = `${tour.start_time}-${tour.end_time}`;
                        // highlight only timeslot buttons
                        timetableDiv.querySelectorAll('.timeslot')
                            .forEach(b => b.classList.remove('selected'));
                        btn.classList.add('selected');
                    };
                    dateDiv.appendChild(btn);
                });

            timetableDiv.appendChild(dateDiv);
        });
    }

    function addToCart() {
        const ticketType = document.querySelector('input[name="ticketType"]:checked');

        if (!ticketType)          return toastr.error('Please select a ticket type.');
        if (!selectedLanguage)    return toastr.error('Please select a language.');
        if (!selectedDate)        return toastr.error('Please select a date.');
        if (!selectedTimeSlot)    return toastr.error('Please select a time slot.');

        if (ticketType.value === 'regular' && regularParticipants === 0)
            return toastr.error('Please enter at least 1 participant.');

        const payload = {
            ticketType:     ticketType.value,
            price:          ticketType.value === 'regular' ? regularParticipants * 17.50 : 60,
            start_location: selectedLanguage,
            timeslot:       `${selectedDate} ${selectedTimeSlot}`,
            participants:   ticketType.value === 'regular' ? regularParticipants : 1
        };


        if( ticketType.value === 'regular' && regularParticipants > 10000 ) {
            return toastr.error('Maximum number of participants is 10000.');
        }

         // SHOW FULL PAGE LOADER
        document.getElementById('pageLoader').style.display = 'flex';


        fetch('/historyTicket/create', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload),
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
              

                setTimeout(() => {
                    toastr.success('Ticket added to cart successfully!');
                    window.location.href = '/personalprogram/personalprogram';
                }, 1200);
                
            } else {
                
                document.getElementById('pageLoader').style.display = 'none';

                toastr.error(data.message || 'Failed to add ticket.');
            }
        })
         .catch(() => {

              setTimeout(() => {
                    document.getElementById('pageLoader').style.display = 'none';
                    toastr.error('Network error. Please try again.');
                }, 1200);
                
        });
    }


    function displayMessage(message, type) {
        const el = document.getElementById('message');
        el.textContent  = message;
        el.className    = type;        
        el.style.display = 'block';
        setTimeout(() => {
            el.style.display = 'none';
            el.className = '';
        }, 3000);
    }
</script>

<div id="pageLoader" class="page-loader">
    <div class="loader-spinner"></div>
    <p>Adding to cart...</p>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>