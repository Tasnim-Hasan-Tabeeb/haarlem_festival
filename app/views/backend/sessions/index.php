<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Session List</h1>
        <a href="/session/create" class="btn btn-success">Add Session</a>
    </div>

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Restaurant</th>
                    <th>Start Time</th>
                    <th>Duration (hours)</th>
                    <th>Sessions Per Day</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($sessions) > 0) { ?>
                    <?php foreach ($sessions as $session) : ?>
                        <tr>
                            <td><?= $session['session_id'] ?></td>
                            <td><?= $session['restaurant_title'] ?></td>
                            <td><?= $session['start_time'] ?></td>
                            <td><?= $session['duration'] ?> hours</td>
                            <td><?= $session['sessions_per_day'] ?><?= ($session['sessions_per_day'] == 1) ? ' session' : ' sessions' ?></td>
                            <td>
                                <a href="/session/edit?id=<?= $session['session_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $session['session_id'] ?>">Delete</button>
                                <div class="modal fade" id="deleteModal<?= $session['session_id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $session['session_id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel<?= $session['session_id'] ?>">Confirm Deletion</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this session?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <a href="/session/delete?id=<?= $session['session_id'] ?>" class="btn btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <tr>
                        <td class="text-center" colspan="6">No Content</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>