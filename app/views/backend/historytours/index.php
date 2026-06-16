<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Tours</h1>
        <a href="/historytour/create" class="btn btn-success">Add Tour</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle text-nowrap">

            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Language</th>
                    <th>Available Guides</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($tours)) : ?>

                    <?php foreach ($tours as $tour) : ?>
                        <tr>

                            <td><?= htmlspecialchars($tour['date']) ?></td>

                            <td><?= htmlspecialchars($tour['start_time']) ?></td>

                            <td><?= htmlspecialchars($tour['end_time']) ?></td>

                            <td><?= htmlspecialchars($tour['name']) ?></td>

                            <td><?= htmlspecialchars($tour['available_guides']) ?></td>

                            <td>
                                <div class="btn-group btn-group-sm" role="group">

                                    <a href="/historytour/edit?id=<?= $tour['tour_id'] ?>"
                                       class="btn btn-primary">
                                        Edit
                                    </a>

                                    <button type="button"
                                            class="btn btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal<?= $tour['tour_id'] ?>">
                                        Delete
                                    </button>

                                </div>

                                <!-- Modal -->
                                <div class="modal fade"
                                     id="deleteModal<?= $tour['tour_id'] ?>"
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
                                                Are you sure you want to delete this tour?
                                            </div>

                                            <div class="modal-footer">

                                                <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                                <a href="/historytour/delete?id=<?= $tour['tour_id'] ?>"
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
                        <td colspan="6" class="text-center py-4 text-muted">
                            No tours found
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>
    </div>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>