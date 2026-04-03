<?php
include __DIR__ . '/../inc/header.php';
?>

<div class="container">
    <?php include __DIR__ . '/../inc/message.php'; ?>

    <div class="d-flex justify-content-between align-items-center">
        <h1>Dance Event List</h1>
        <a href="/dancemanagement/create" class="btn btn-success">Add Dance Event</a>
    </div>
    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>ID</th>
                <th>Image</th>
                <th>Title</th>
                <th>Event Date</th>
                <th>Start Time</th>
                <th>Price</th>
                <th>Duration</th>
                <th>Session Type</th>
                <th>Venue</th>
                <th>Artists</th>
            </tr>
            </thead>
            <tbody>


            <?php foreach ($dancesManages as $dance) : ?>
                <tr>
                    <td><?= $dance['music_event_id'] ?></td>
                    <td><img src="<?= '/images/' . $dance['music_event_image'] ?>" alt="<?= $dance['music_event_image'] ?>" style="width: 100px;"></td>
                    <td><?= $dance['event_name'] ?></td>
                    <td><?= $dance['event_date'] ?></td>
                    <td><?= $dance['event_start_time'] ?></td>
                    <td>&euro;<?= $dance['event_price'] ?></td>
                    <td><?= $dance['event_duration'] ?> minutes</td>
                    <td><?= $dance['session_type'] ?></td>
                    <td><?= $dance['venue_name'] ?></td>
                    <td><?= $dance['artist_names'] ?></td>
                    <td>
                        <a href="/dancemanagement/edit?id=<?= $dance['music_performance_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $dance['music_performance_id'] ?>">Delete</button>
                        <div class="modal fade" id="deleteModal<?= $dance['music_performance_id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $dance['music_performance_id'] ?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteModalLabel<?= $dance['music_performance_id'] ?>">Confirm Deletion</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete this event?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <a href="/dancemanagement/delete?id=<?= $dance['music_performance_id'] ?>" class="btn btn-danger">Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
            <?php endforeach; ?>

            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>
