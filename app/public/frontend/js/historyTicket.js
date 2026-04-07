let selectedLanguage = null;
let selectedDate = null;
let selectedTimeSlot = null;
let regularParticipants = 0;

document.addEventListener("DOMContentLoaded", function () {
    populateLanguages();
    attachEventListeners();
});

function attachEventListeners() {
    document.getElementById("regularParticipants").addEventListener("input", handleParticipantChange);
    document.getElementById("regular").addEventListener("change", handleTicketTypeChange);
    document.getElementById("family").addEventListener("change", handleTicketTypeChange);
}

function handleTicketTypeChange(event) {
    const regularInput = document.getElementById("regularParticipants");

    if (event.target.value === "family") {
        regularInput.value = 0;
        regularInput.disabled = true;
        regularParticipants = 0;
    } else {
        regularInput.disabled = false;
    }

    calculateTotal();
}

function handleParticipantChange(event) {
    if (event.target.id === "regularParticipants") {
        regularParticipants = parseInt(event.target.value) || 0;

        if (regularParticipants >= 4) {
            alert("Buy a family ticket and save 10 euros");
        }
    }

    calculateTotal();
}

function calculateTotal() {
    let total = 0;

    if (document.getElementById("regular").checked) {
        total = regularParticipants * 17.5;
    } else if (document.getElementById("family").checked) {
        total = 60;
    }

    document.getElementById("total").textContent = total.toFixed(2);
}

function populateLanguages() {
    const languagesDiv = document.getElementById("languages");
    const tours = JSON.parse(languagesDiv.getAttribute("data-languages") || "[]");

    languagesDiv.innerHTML = "";

    const languages = new Set();

    tours.forEach((tour) => {
        if (!languages.has(tour.name)) {
            languages.add(tour.name);

            const button = document.createElement("button");
            button.type = "button";
            button.textContent = tour.name;

            button.onclick = () => {
                selectedLanguage = tour.name;
                highlightSelection(button, "languages");
                filterByLanguage(tour.name);
            };

            languagesDiv.appendChild(button);
        }
    });
}

function highlightSelection(selectedButton, containerId) {
    const container = document.getElementById(containerId);
    const buttons = container.querySelectorAll("button");

    buttons.forEach((button) => button.classList.remove("selected"));
    selectedButton.classList.add("selected");
}

function fetchTours(language = null) {
    let url = "/history/getToursByLanguage";

    if (language) {
        url += `?language_name=${encodeURIComponent(language)}`;
    }

    fetch(url)
        .then((response) => response.json())
        .then((data) => {
            if (data.error) {
                console.error("Error fetching tours:", data.error);
            } else {
                populateTimetable(data);
            }
        })
        .catch((error) => console.error("Error fetching tours:", error));
}

function populateTimetable(tours) {
    const timetableDiv = document.getElementById("timetable");
    timetableDiv.innerHTML = "";

    const dates = [...new Set(tours.map((tour) => tour.date))];

    dates.forEach((date) => {
        const dateDiv = document.createElement("div");
        dateDiv.classList.add("date");

        const dateTitle = document.createElement("span");
        dateTitle.classList.add("date-title");
        dateTitle.textContent = date;
        dateDiv.appendChild(dateTitle);

        tours
            .filter((tour) => tour.date === date)
            .forEach((tour) => {
                if (tour.available_guides > 0) {
                    const timeBtn = document.createElement("button");
                    timeBtn.type = "button";
                    timeBtn.classList.add("timeslot");
                    timeBtn.textContent = `${tour.start_time}-${tour.end_time}`;

                    timeBtn.onclick = () => {
                        selectedDate = date;
                        selectedTimeSlot = `${tour.start_time}-${tour.end_time}`;
                        highlightSelection(timeBtn, "timetable");
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
        alert("Please select a ticket type (Regular or Family) before adding to cart.");
        return;
    }

    if (!selectedLanguage) {
        alert("Please select a language");
        displayMessage("Please select language, date and time.", "error");
        return;
    }

    if (!selectedDate) {
        alert("Please select a date");
        displayMessage("Please select date.", "error");
        return;
    }

    if (!selectedTimeSlot) {
        alert("Please select a time");
        displayMessage("Please select time.", "error");
        return;
    }

    if (ticketType.value === "regular" && regularParticipants === 0) {
        alert("Please select at least one regular participant before adding to cart.");
        return;
    }

    const payload = {
        ticketType: ticketType.value,
        price: ticketType.value === "regular" ? regularParticipants * 17.5 : 60,
        start_location: selectedLanguage,
        timeslot: selectedDate + " " + selectedTimeSlot,
        participants: ticketType.value === "regular" ? regularParticipants : 1
    };

    fetch("/historyTicket/create", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
        },
        body: JSON.stringify(payload),
    })
        .then((response) => response.json())
        .then((data) => {
            if (data.success) {
                displayMessage("Ticket added to cart successfully!", "success");
                setTimeout(() => {
                    window.location.href = "/personalprogram/personalprogram";
                }, 3000);
            } else {
                displayMessage(`Error: ${data.message || "Adding ticket to cart failed."}`, "error");
            }
        })
        .catch((error) => {
            console.error("Error adding to cart:", error);
            displayMessage("Error adding ticket to cart.", "error");
        });
}

function addToWishList() {
    displayMessage("Wish list function is not implemented yet.", "error");
}

function displayMessage(message, type) {
    const messageDiv = document.getElementById("message");
    messageDiv.textContent = message;
    messageDiv.style.color = type === "success" ? "#7CFC98" : "#FFD2D2";
    messageDiv.style.display = "block";

    setTimeout(() => {
        messageDiv.textContent = "";
        messageDiv.style.display = "none";
    }, 3000);
}