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

  function getLineTotal(item) {
    if (item.reservation_date) {
      const totalAdults = Number(item.total_adult || 0);
      const totalChildren = Number(item.total_children || 0);
      const costPerPerson = Number(item.cost_per_person || 0);

      return costPerPerson * (totalAdults + totalChildren);
    }

    if (item.music_performance_id !== undefined) {
      return Number(item.event_price || 0) * Number(item.quantity || 1);
    }

    if (item.passType) {
      return Number(item.passPrice || item.cost || 0) * Number(item.quantity || 1);
    }

    return Number(item.cost || item.price || 0);
  }

  function formatPrice(amount) {
    return `EUR ${Number(amount || 0).toFixed(2)}`;
  }

  function isAdjustableQuantityItem(item) {
    return (
      Object.prototype.hasOwnProperty.call(item, "quantity") ||
      Boolean(item.ticketType)
    );
  }

  function getAdjustableQuantity(item) {
    if (Object.prototype.hasOwnProperty.call(item, "quantity")) {
      return Number(item.quantity || 1);
    }

    if (item.ticketType) {
      return Number(item.participants || 1);
    }

    return 1;
  }

  function createListItem(item, index) {
    const listItem = document.createElement("div");
    listItem.className = "list-view__item";

    let itemTitle = "";
    let itemDetails = "";
    let itemQuantity = "";
    let itemCost = formatPrice(getLineTotal(item));
    let quantityControls = "";

    if (item.reservation_date) {
      itemTitle = `${item.name} - ${item.reservation_date}`;
      itemQuantity = `${item.total_adult} adults & ${item.total_children} children`;
      listItem.setAttribute("data-type", "Reservation");
    } else if (item.ticketType) {
      itemTitle = `${item.start_location} - ${item.timeslot}`;
      itemDetails = `Ticket Type: ${item.ticketType.ticket_type}`;
      itemQuantity = `Participants: ${item.participants}`;
      listItem.setAttribute("data-type", "History Ticket");
    } else if (item.music_performance_id !== undefined) {
      itemTitle = `${item.event_name} - ${item.event_date} - ${item.event_start_time}-${calculateEndTime(item.event_start_time, item.event_duration)}`;
      itemDetails = `Session Type: ${item.session_type}`;
      itemQuantity = `Quantity: ${item.quantity}`;
      listItem.setAttribute("data-type", "Dance Ticket");
    } else if (item.passType) {
      itemTitle = `${item.passName} - ${item.passDescription}`;
      itemQuantity = `Quantity: ${item.quantity}`;
      listItem.setAttribute("data-type", "Dance Pass");
    } else {
      listItem.innerHTML = `<div class="empty-item-text">Event information missing or invalid.</div>`;
      return listItem;
    }

    if (isAdjustableQuantityItem(item)) {
      const adjustableQuantity = getAdjustableQuantity(item);

      quantityControls = `
        <div class="quantity-controls">
          <button class="quantity-btn" data-index="${index}" data-change="-1" type="button" ${adjustableQuantity <= 1 ? "disabled" : ""}>-</button>
          <span class="quantity-value">${adjustableQuantity}</span>
          <button class="quantity-btn" data-index="${index}" data-change="1" type="button">+</button>
        </div>
      `;
    }

    listItem.innerHTML = `
      <div class="list-view__item__left">
        <div class="list-view__item__title">${itemTitle}</div>
        ${itemDetails ? `<div class="list-view__item__subheading">${itemDetails}</div>` : ""}
        <div class="list-view__item__info">${itemQuantity}</div>
      </div>
      <div class="list-view__item__right">
        <div class="list-view__item__price">${itemCost}</div>
        ${quantityControls}
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

    $(".quantity-btn").off("click").on("click", updateQuantity);
    $(".delete-btn").off("click").on("click", deleteItem);
  }

  function updateQuantity() {
    const button = $(this);
    const index = Number(button.data("index"));
    const change = Number(button.data("change"));
    const item = reservations[index];

    if (!item || !isAdjustableQuantityItem(item)) {
      return;
    }

    const newQuantity = getAdjustableQuantity(item) + change;
    if (newQuantity < 1) {
      return;
    }

    $.ajax({
      url: "/personalprogram/updateItemQuantity",
      type: "POST",
      data: { index: index, quantity: newQuantity },
      success: function (response) {
        if (response && response.success) {
          reservations[index] = response.item;
          populateListView();
          return;
        }

        console.error("Error updating quantity:", response?.message || "Unknown error");
      },
      error: function (xhr) {
        console.error("Error updating quantity:", xhr.responseText || xhr.statusText);
      }
    });
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
