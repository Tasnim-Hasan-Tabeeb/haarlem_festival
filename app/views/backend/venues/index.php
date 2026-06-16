<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container">

    <?php include __DIR__ . '/../inc/message.php'; ?>


    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Venue List</h1>
        <a href="/venue/create" class="btn btn-success">Add Venue</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle text-nowrap">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Location</th>
                    <th>Capacity</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($venues as $venue) : ?>
                    <tr>

                        <td><?= htmlspecialchars($venue['venue_id']) ?></td>

                        <td>
                            <img src="<?=  $venue['venue_image'] ?>"
                                 alt="<?= htmlspecialchars($venue['venue_name']) ?>"
                                 class="img-thumbnail"
                                 width="70"
                                 height="70">
                        </td>

                        <td><?= htmlspecialchars($venue['venue_name']) ?></td>

                        <td><?= htmlspecialchars($venue['venue_location']) ?></td>

                        <td><?= htmlspecialchars($venue['capacity']) ?></td>

                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="/venue/edit?id=<?= $venue['venue_id'] ?>"
                                   class="btn btn-primary">
                                    Edit
                                </a>

                                <button type="button"
                                        class="btn btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal<?= $venue['venue_id'] ?>">
                                    Delete
                                </button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade"
                                 id="deleteModal<?= $venue['venue_id'] ?>"
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
                                            Are you sure you want to delete this venue?
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button"
                                                    class="btn btn-secondary"
                                                    data-bs-dismiss="modal">
                                                Cancel
                                            </button>

                                            <a href="/venue/delete?id=<?= $venue['venue_id'] ?>"
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
            </tbody>

        </table>
    </div>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>