<?php
include __DIR__ . '/../inc/header.php';
?>

    <div class="container">

        <?php include __DIR__ . '/../inc/message.php'; ?>

        <div class="d-flex justify-content-between align-items-center">
            <h1>Event List</h1>
            <a href="/events/create" class="btn btn-success">Add Event</a>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Primary Color</th>
                    <th>Secondary Color</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($events as $event) : ?>
                    <tr>
                        <td><?= $event['event_id'] ?></td>
                        <td><img src="<?= '/images/' .  $event['image_url'] ?>" alt="<?= $event['image_url'] ?>" style="width: 100px;"></td>
                        <td><?= $event['event_type'] ?></td>
                        <td><?= $event['title'] ?></td>
                        <td><?= $event['description'] ?></td>
                        <td><?= $event['status'] ?></td>
                        <td><?= $event['start_date'] ?></td>
                        <td><?= $event['end_date'] ?></td>
                        <td><?= $event['primary_theme_color'] ?></td>
                        <td><?= $event['secondary_theme_color'] ?></td>
                        <td>
                            <a href="/events/edit?id=<?= $event['event_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $event['event_id'] ?>">Delete</button>
                            <div class="modal fade" id="deleteModal<?= $event['event_id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $event['event_id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel<?= $event['event_id'] ?>">Confirm Deletion</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this event?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <a href="/events/delete?id=<?= $event['event_id'] ?>" class="btn btn-danger">Delete</a>
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