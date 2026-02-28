<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container mb-5">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <h1>Create Reservation</h1>
    <div class="mt-4">
        <form action="/reservation/store" method="POST" autocomplete="off" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="reservation_date" class="form-label">Reservation Date</label>
                <input type="date" class="form-control" id="reservation_date" name="reservation_date" required>
            </div>
            <div class="mb-3">
                <label for="total_adult" class="form-label">Total Adults</label>
                <input type="number" min="1" class="form-control" id="total_adult" name="total_adult" required>
            </div>
            <div class="mb-3">
                <label for="total_children" class="form-label">Total Children</label>
                <input type="number" min="0" class="form-control" id="total_children" name="total_children" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="phone" class="form-label">Phone</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="mb-3">
                <label for="restaurant_id" class="form-label">Restaurant</label>
                <select id="restaurant_id" name="restaurant_id" class="form-control" required>
                    <option value="">Select Restaurant</option>
                    <?php foreach ($restaurants as $restaurant) : ?>
                        <option value="<?= $restaurant['restaurant_id'] ?>"><?= $restaurant['title'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="session_id" class="form-label">Session</label>
                <select id="session_id" name="session_id" class="form-control" required>
                    <option value="">Select Session</option>
                    <!-- Sessions will be dynamically populated based on restaurant selection -->
                </select>
            </div>
            <div class="mb-3">
                <label for="remarks" class="form-label">Remarks</label>
                <textarea id="remarks" name="remarks" class="form-control"></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Create</button>
        </form>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>

<script>
    $(document).ready(function() {
        $('#restaurant_id').change(function() {
            var restaurantId = $(this).val();
            if (restaurantId) {
                $.ajax({
                    url: '/reservation/getByRestaurant?id=' + restaurantId,
                    method: 'GET',
                    success: function(data) {
                        var sessions = JSON.parse(data);
                        $('#session_id').empty().append('<option value="">Select Session</option>');
                        if (!sessions.error) {
                            $.each(sessions, function(index, session) {
                                $('#session_id').append('<option value="' + session.session_id + '">' + session.start_time + ' (' + session.duration + ' hours)</option>');
                            });
                        } else {
                            alert(sessions.error);
                        }
                    },
                    error: function() {
                        alert('Failed to fetch sessions. Please try again.');
                    }
                });
            } else {
                $('#session_id').empty().append('<option value="">Select Session</option>');
            }
        });
    });
</script>