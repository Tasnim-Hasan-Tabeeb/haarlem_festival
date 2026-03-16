(function () {
  const reservations = Array.isArray(window.personalProgramReservations)
    ? window.personalProgramReservations
    : [];

  function calculateEndTime(startTime, duration) {
    const start = new Date(`2000-01-01T${startTime}`);
    const end = new Date(start.getTime() + duration * 60000);

    return end.toLocaleTimeString("en-GB", {
      hour: "2-digit",
      minute: "2-digit",
      hour12: false
    });
  }

  function createListItem(item, index) {
    const listItem = document.createElement("div");
    listItem.className = "list-view__item";

    let itemTitle = "";
    let itemDetails = "";
    let itemQuantity = "";
    let itemCost = "";

    if (item.reservation_date) {
      itemTitle = `${item.name} - ${item.reservation_date}`;
      itemQuantity = `${item.total_adult} adults & ${item.total_children} children`;
      itemCost = `€${item.cost}`;
      listItem.setAttribute("data-type", "Reservation");
    } else if (item.ticketType) {
      itemTitle = `${item.start_location} - ${item.timeslot}`;
      itemDetails = `Ticket Type: ${item.ticketType.ticket_type}`;
      itemQuantity = `Participants: ${item.participants}`;
      itemCost = `€${item.price}`;
      listItem.setAttribute("data-type", "History Ticket");
    } else if (item.music_performance_id !== undefined) {
      itemTitle = `${item.event_name} - ${item.event_date} - ${item.event_start_time}-${calculateEndTime(item.event_start_time, item.event_duration)}`;
      itemDetails = `Session Type: ${item.session_type}`;
      itemQuantity = `Quantity: ${item.quantity}`;
      itemCost = `€${item.event_price}`;
      listItem.setAttribute("data-type", "Dance Ticket");
    } else if (item.passType) {
      itemTitle = `${item.passName} - ${item.passDescription}`;
      itemQuantity = `Quantity: ${item.quantity}`;
      itemCost = `€${item.cost}`;
      listItem.setAttribute("data-type", "Dance Pass");
    } else {
      listItem.innerHTML = `<div class="empty-item-text">Event information missing or invalid.</div>`;
      return listItem;
    }

    listItem.innerHTML = `
      <div class="list-view__item__left">
        <div class="list-view__item__title">${itemTitle}</div>
        ${itemDetails ? `<div class="list-view__item__subheading">${itemDetails}</div>` : ""}
        <div class="list-view__item__info">${itemQuantity}</div>
      </div>
      <div class="list-view__item__right">
        <div class="list-view__item__price">${itemCost}</div>
        <button class="delete-btn" data-index="${index}" type="button">Delete</button>
      </div>
    `;

    return listItem;
  }

  function populateListView() {
    const listView = document.getElementById("list-view");
    if (!listView) return;

    listView.innerHTML = "";

    if (!reservations.length) {
      listView.innerHTML = `
        <div class="empty-state">
          Your personal program is empty.
        </div>
      `;
      return;
    }

    reservations.forEach((item, index) => {
      const listItem = createListItem(item, index);
      listView.appendChild(listItem);
    });

    $(".delete-btn").off("click").on("click", deleteItem);
  }

  function deleteItem() {
    const button = $(this);
    const index = button.data("index");

    $.ajax({
      url: "/personalprogram/removeItem",
      type: "GET",
      data: { index: index },
      success: function () {
        reservations.splice(index, 1);
        populateListView();
      },
      error: function (xhr, status, error) {
        console.error("Error deleting item:", error);
      }
    });
  }

  $(document).ready(function () {
    populateListView();
  });
})();