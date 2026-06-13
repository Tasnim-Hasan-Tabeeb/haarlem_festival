<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <!-- HEADER -->
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Dance Event List</h1>
        <a href="/dancemanagement/create" class="btn btn-success">
            Add Dance Event
        </a>
    </div>

    <!-- TABLE -->
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Title</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Session</th>
                    <th>Venue</th>
                    <th>Artists</th>
                    <th class="col-actions">Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($dancesManages)) : ?>

                    <?php foreach ($dancesManages as $dance) : ?>
                        <tr>

                            <td><?= htmlspecialchars($dance['music_event_id']) ?></td>

                            <td>
                                <?php if (!empty($dance['music_event_image'])) : ?>
                                    <img src="<?= htmlspecialchars($dance['music_event_image']) ?>"
                                         alt="Event Image"
                                         class="table-img img-thumbnail"
                                         width="80"
                                         height="80"
                                         >
                                <?php else : ?>
                                    <span class="text-muted">No Image</span>
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($dance['event_name']) ?></td>

                            <td><?= htmlspecialchars($dance['event_date']) ?></td>

                            <td><?= htmlspecialchars($dance['event_start_time']) ?></td>

                            <td>€<?= htmlspecialchars($dance['event_price']) ?></td>

                            <td><?= htmlspecialchars($dance['event_duration']) ?> min</td>

                            <td><?= htmlspecialchars($dance['session_type']) ?></td>

                            <td><?= htmlspecialchars($dance['venue_name']) ?></td>

                            <td><?= htmlspecialchars($dance['artist_names']) ?></td>

                            <td>
                                <div class="btn-group btn-group-sm" role="group">

                                    <a href="/dancemanagement/edit?id=<?= $dance['music_performance_id'] ?>"
                                       class="btn btn-primary">
                                        Edit
                                    </a>

                                    <button type="button"
                                            class="btn btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal<?= $dance['music_performance_id'] ?>">
                                        Delete
                                    </button>

                                </div>

                                <!-- MODAL -->
                                <div class="modal fade"
                                     id="deleteModal<?= $dance['music_performance_id'] ?>"
                                     tabindex="-1"
                                     aria-hidden="true">

                                    <div class="modal-dialog">
                                        <div class="modal-content">

                                            <div class="modal-header">
                                                <h5 class="modal-title">Confirm Deletion</h5>
                                                <button type="button"
                                                        class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                Are you sure you want to delete this event?
                                            </div>

                                            <div class="modal-footer">

                                                <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                                <a href="/dancemanagement/delete?id=<?= $dance['music_performance_id'] ?>"
                                                   class="btn btn-danger">
                                                    Delete
                                                </a>

                                            </div>

                                        </div>
                                    </div>

                                </div>

                            </td>

                        </tr>
                    <?php endforeach; ?>

                <?php else : ?>

                    <tr>
                        <td colspan="11" class="text-center py-4 text-muted">
                            No dance events found
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>
    </div>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>