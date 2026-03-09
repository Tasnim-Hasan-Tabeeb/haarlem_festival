<?php include __DIR__ . '/../inc/header.php'; ?>
<title>History Ticket</title>
</head>
<style>
    @import url("https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2:wght@400;500;600;700;800&display=swap");

    body {
        font-family: Arial, sans-serif;
        background-color: #780B1E;
        color: white;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
    }

    #app {
        width: 80%;
        max-width: 600px;
        text-align: center;
    }

    h1 {
        font-size: 2em;
    }

    .section {
        margin: 20px 0;
    }

    .languages img {
        width: 40px;
        height: 30px;
        margin: 0 5px;
        cursor: pointer;
        border: 2px solid transparent;
    }

    .languages img.selected {
        border-color: white;
    }

    .languages button.selected, .timetable .timeslot.selected {
        background-color: #fcb347;
        color: #780B1E;
    }

    .timetable .date {
        margin: 10px 0;
    }

    .timetable .date button {
        background-color: #FCEBBD;
        border: none;
        color: #780B1E;
        padding: 10px;
        margin: 5px;
        cursor: pointer;
        border-radius: 5px;
    }

    .timetable .date button:hover {
        background-color: #FCEBBD;
    }

    .regularParticipants,
    .familyParticipants {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        margin: 10px 0; /* Add margin to space out the sections */
    }

    .participants label, .participants input {
        margin: 5px;
        font-size: 1.2em; /* Increase the font size */
    }

    input[type="radio"] {
        width: 20px; /* Increase the size of radio buttons */
        height: 20px;
        margin-right: 10px; /* Add some space between radio button and label */
    }

    input[type="number"] {
        font-size: 1.2em; /* Increase the size of the number input */
        padding: 5px; /* Add some padding */
        width: 80px; /* Adjust the width */
    }

    button {
        background-color: #FCEBBD;
        border: none;
        color: #780B1E;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 5px;
        margin: 10px;
    }

    button:hover {
        background-color: #FCEBBD;
    }

    #total {
        font-weight: bold;
    }

    #message {
        margin: 20px 0;
        color: green;
        font-weight: bold;
        display: none;
    }
</style>
<body>
<div id="app">
    <h1>A Stroll Through History</h1>
    <p>EMBARK ON YOUR HAARLEM JOURNEY WITH JUST A FEW CLICKS</p>

    <div class="section">
        <label>Select Language:</label>
        <div id="languages" class="languages" data-languages='<?php echo json_encode($tours); ?>'>
            <!-- JavaScript will populate this section -->
        </div>
    </div>

    <div class="section">
        <label>Select Date and Time:</label>
        <div id="timetable" class="timetable">
            <!-- JavaScript will populate this section -->
        </div>
    </div>

    <div class="section">
        <label>Select number of Participants:</label>
        <div class="regularParticipants">
            <input type="radio" id="regular" name="ticketType" value="regular">
            <label for="regularParticipants">Regular Participant</label>
            <input type="number" id="regularParticipants" min="0" value="0">
        </div>
        <div class="familyParticipants">
            <input type="radio" id="family" name="ticketType" value="family">
            <label for="familyParticipants">Family Ticket (fixed price €60)</label>
        </div>
    </div>

    <div class="section">
        <p>Total: € <span id="total">00,00</span></p>
        <button onclick="addToCart()">Add to Cart</button>
        <button onclick="addToWishList()">Add to Wish List</button>
    </div>

    <div id="message"></div>
</div>
<script>
    let selectedLanguage = null;
    let selectedDate = null;
    let selectedTimeSlot = null;
    let regularParticipants = 0;
    let familyParticipants = 0;

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
        if (event.target.value === 'family') {
            document.getElementById('regularParticipants').value = 0;
            document.getElementById('regularParticipants').disabled = true;
            regularParticipants = 0;
        } else {
            document.getElementById('regularParticipants').disabled = false;
        }
        calculateTotal();
    }

    function handleParticipantChange(event) {
        if (event.target.id === 'regularParticipants') {
            regularParticipants = parseInt(event.target.value) || 0;
            if (regularParticipants >= 4) {
                alert('Buy a family ticket and save 10 euros');
            }
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

        const languages = new Set();
        tours.forEach(tour => {
            if (!languages.has(tour.language_name)) {
                languages.add(tour.language_name);
                const button = document.createElement('button');
                button.innerHTML = `<img src="/images/${tour.flag_image}" alt="${tour.language_name}">`;
                button.onclick = () => {
                    selectedLanguage = tour.language_name;
                    highlightSelection(button, 'languages');
                    filterByLanguage(tour.language_name);
                };
                languagesDiv.appendChild(button);
            }
        });
    }

    function highlightSelection(selectedButton, containerId) {
        const container = document.getElementById(containerId);
        const buttons = container.getElementsByTagName('button');
        for (let button of buttons) {
            button.classList.remove('selected');
        }
        selectedButton.classList.add('selected');
    }

    function fetchTours(language = null) {
        let url = '/history/getToursByLanguage';
        if (language) {
            url += `?language_name=${encodeURIComponent(language)}`;
        }

        fetch(url)
            .then(response => response.json())
            .then(data => {
                console.log('Server response for tours:', data); // Debugging line
                if (data.error) {
                    console.error('Error fetching tours:', data.error);
                } else {
                    populateTimetable(data);
                }
            })
            .catch(error => console.error('Error fetching tours:', error));
    }

    function populateTimetable(tours) {
        const timetableDiv = document.getElementById('timetable');
        timetableDiv.innerHTML = '';

        const dates = new Set(tours.map(tour => tour.date));

        dates.forEach(date => {
            const dateDiv = document.createElement('div');
            dateDiv.classList.add('date');
            dateDiv.textContent = date;

            tours.filter(tour => tour.date === date).forEach(tour => {
                if (tour.available_guides > 0) {
                    const timeBtn = document.createElement('button');
                    timeBtn.classList.add('timeslot');
                    timeBtn.textContent = `${tour.start_time}-${tour.end_time}`;
                    timeBtn.onclick = () => {
                        selectedDate = date;
                        selectedTimeSlot = `${tour.start_time}-${tour.end_time}`;
                        highlightSelection(timeBtn, 'timetable');
                    };
                    dateDiv.appendChild(timeBtn);
                }
            });

            timetableDiv.appendChild(dateDiv);
        });
    }

    function filterByLanguage(language) {
        fetchTours(language);
    }

    function addToCart() {
        const ticketType = document.querySelector('input[name="ticketType"]:checked');

        if (!ticketType) {
            alert('Please select a ticket type (Regular or Family) before adding to cart.');
            return;
        }

        const payload = {
            ticketType: ticketType.value,
            price: ticketType.value === 'regular' ? regularParticipants * 17.50 : 60,
            start_location: selectedLanguage,
            timeslot: selectedDate + ' ' + selectedTimeSlot,
            participants: ticketType.value === 'regular' ? regularParticipants : 1
        };

        console.log('Adding to cart:', payload); // Debugging line

        fetch('/historyTicket/create', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(payload),
        })
            .then(response => response.json())
            .then(data => {
                console.log('Server response for add to cart:', data); // Debugging line
                if (data.success) {
                    displayMessage('Ticket added to cart successfully!', 'success');
                    setTimeout(() => {
                        window.location.href = '/home/page?slug=history&id=${currentId}'; // Redirect to the history page after a brief delay
                    }, 3000); // 3 seconds delay before redirect
                } else {
                    displayMessage(`Error: ${data.message || 'Adding ticket to cart failed.'}`, 'error');
                }
            })
            .catch(error => {
                console.error('Error adding to cart:', error);
                displayMessage('Error adding ticket to cart.', 'error');
            });
    }

    function displayMessage(message, type) {
        const messageDiv = document.getElementById('message');
        messageDiv.textContent = message;
        messageDiv.style.color = type === 'success' ? 'green' : 'red';
        messageDiv.style.display = 'block';
        setTimeout(() => {
            messageDiv.textContent = '';
            messageDiv.style.display = 'none';
        }, 3000);
    }
</script>
</body>
