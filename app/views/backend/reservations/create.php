<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1 class="mb-4">Create Reservation</h1>

    <form action="/reservation/store" method="POST" autocomplete="off">

        <!-- NAME -->
        <div class="mb-3">
            <label for="name" class="form-label">
                Name <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control"
                   id="name"
                   name="name"
                   placeholder="Enter customer name"
                   required>
        </div>

        <!-- DATE -->
        <div class="mb-3">
            <label for="reservation_date" class="form-label">
                Reservation Date <span class="text-danger">*</span>
            </label>
            <input type="date"
                   class="form-control"
                   id="reservation_date"
                   name="reservation_date"
                   required>
        </div>

        <!-- ADULT -->
        <div class="mb-3">
            <label for="total_adult" class="form-label">
                Total Adults <span class="text-danger">*</span>
            </label>
            <input type="number"
                   min="0"
                   class="form-control"
                   id="total_adult"
                   name="total_adult"
                   placeholder="e.g. 2"
                   max="1000"

                   required>
        </div>

        <!-- CHILD -->
        <div class="mb-3">
            <label for="total_children" class="form-label">
                Total Children <span class="text-danger">*</span>
            </label>
            <input type="number"
                   min="0"
                   class="form-control"
                   id="total_children"
                   name="total_children"
                   max="10000"
                   placeholder="e.g. 1">
        </div>

        <!-- EMAIL -->
        <div class="mb-3">
            <label for="email" class="form-label">
                Email <span class="text-danger">*</span>
            </label>
            <input type="email"
                   class="form-control"
                   id="email"
                   name="email"
                   placeholder="example@email.com"
                   required>
        </div>

        <!-- PHONE -->
        <div class="mb-3">
            <label for="phone" class="form-label">
                Phone <span class="text-danger">*</span>
            </label>
            <input type="text"
                   class="form-control"
                   id="phone"
                   name="phone"
                   placeholder="+8801XXXXXXXXX"
                   required>
        </div>

        <!-- RESTAURANT -->
        <div class="mb-3">
            <label for="restaurant_id" class="form-label">
                Restaurant <span class="text-danger">*</span>
            </label>
            <select id="restaurant_id"
                    name="restaurant_id"
                    class="form-select"
                    required>
                <option value="">Select Restaurant</option>
                <?php foreach ($restaurants as $restaurant) : ?>
                    <option value="<?= $restaurant['restaurant_id'] ?>">
                        <?= htmlspecialchars($restaurant['title']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <!-- SESSION -->
        <div class="mb-3">
            <label for="session_id" class="form-label">
                Session <span class="text-danger">*</span>
            </label>
            <select id="session_id"
                    name="session_id"
                    class="form-select"
                    required>
                <option value="">Select restaurant first</option>
            </select>
        </div>

        <!-- REMARKS -->
        <div class="mb-4">
            <label for="remarks" class="form-label">Remarks</label>
            <textarea id="remarks"
                      name="remarks"
                      class="form-control"
                      rows="3"
                      placeholder="Optional notes"></textarea>
        </div>

        <!-- BUTTON -->
        <button type="submit" class="btn btn-primary">
            Create Reservation
        </button>

    </form>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>

<script>
$(function () {
    $('#restaurant_id').on('change', function () {
        let id = $(this).val();

        if (!id) {
            $('#session_id').html('<option value="">Select restaurant first</option>');
            return;
        }

        $('#session_id').html('<option>Loading...</option>');

        $.get('/reservation/getByRestaurant?id=' + id, function (res) {
            let data = JSON.parse(res);

            $('#session_id').empty().append('<option value="">Select Session</option>');

            if (!data.error) {
                data.forEach(s => {
                    $('#session_id').append(
                        `<option value="${s.session_id}">
                            ${s.start_time} (${s.duration} hrs)
                        </option>`
                    );
                });
            } 
        }).fail(() => {
            
        });
    });
});
</script>