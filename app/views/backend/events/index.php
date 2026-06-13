<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Event List</h1>
        <a href="/events/create" class="btn btn-success">Add Event</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle text-nowrap">

            <thead class="table-dark">
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
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($events)) : ?>

                    <?php foreach ($events as $event) : ?>
                        <tr>

                            <td><?= htmlspecialchars($event['event_id']) ?></td>

                            <td>
                                <?php if (!empty($event['image_url'])) : ?>
                                    <img src="<?=  htmlspecialchars($event['image_url']) ?>"
                                         alt="Event Image"
                                         class="img-thumbnail"
                                         width="70"
                                         height="70">
                                <?php else : ?>
                                    <span class="text-muted">No Image</span>
                                <?php endif; ?>
                            </td>

                            <td><?= htmlspecialchars($event['event_type']) ?></td>

                            <td><?= htmlspecialchars($event['title']) ?></td>

                            <td>
                                <?= htmlspecialchars(mb_strimwidth($event['description'], 0, 120, '...')) ?>
                            </td>

                            <td><?= htmlspecialchars($event['status'] == 0 ? 'Inactive' : 'Active') ?></td>

                            <td><?= htmlspecialchars($event['start_date']) ?></td>

                            <td><?= htmlspecialchars($event['end_date']) ?></td>

                            <td><?= htmlspecialchars($event['primary_theme_color']) ?></td>

                            <td><?= htmlspecialchars($event['secondary_theme_color']) ?></td>

                            <td>
                                <div class="btn-group btn-group-sm" role="group">

                                    <a href="/events/edit?id=<?= $event['event_id'] ?>"
                                       class="btn btn-primary">
                                        Edit
                                    </a>

                                    <button type="button"
                                            class="btn btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal<?= $event['event_id'] ?>">
                                        Delete
                                    </button>

                                </div>

                                <!-- Modal -->
                                <div class="modal fade"
                                     id="deleteModal<?= $event['event_id'] ?>"
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

                                                <a href="/events/delete?id=<?= $event['event_id'] ?>"
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
                            No events found
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>
    </div>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>