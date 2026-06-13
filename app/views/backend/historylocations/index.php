<?php include __DIR__ . '/../inc/header.php'; ?>

<style>
.col-description {
    min-width: 250px;
}
</style>

<div class="container">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Locations List</h1>
        <a href="/historylocation/create" class="btn btn-success">Add Location</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th class="col-description">Description</th>
                    <th>Address</th>
                    <th>Contact Info</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($locations)) : ?>

                    <?php foreach ($locations as $location) : ?>
                        <tr>

                            <td><?= htmlspecialchars($location['tour_location_id']) ?></td>

                            <td><?= htmlspecialchars($location['location_name']) ?></td>

                            <td>
                                <?= htmlspecialchars(mb_strimwidth($location['description'], 0, 120, '...')) ?>
                            </td>

                            <td><?= htmlspecialchars($location['address']) ?></td>

                            <td><?= htmlspecialchars($location['contact_info']) ?></td>

                            <td>
                                <?php if (!empty($location['images'])) : ?>
                                    <img src="<?=  htmlspecialchars($location['images']) ?>"
                                         alt="<?= htmlspecialchars($location['location_name']) ?>"
                                         class="img-thumbnail"
                                         width="80"
                                         height="80">
                                <?php else : ?>
                                    <span class="text-muted">No Image</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="btn-group btn-group-sm" role="group">

                                    <a href="/historylocation/edit?id=<?= $location['tour_location_id'] ?>"
                                       class="btn btn-primary">
                                        Edit
                                    </a>

                                    <button type="button"
                                            class="btn btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal<?= $location['tour_location_id'] ?>">
                                        Delete
                                    </button>

                                </div>

                                <!-- Modal -->
                                <div class="modal fade"
                                     id="deleteModal<?= $location['tour_location_id'] ?>"
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
                                                Are you sure you want to delete this location?
                                            </div>

                                            <div class="modal-footer">

                                                <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                                <a href="/historylocation/delete?id=<?= $location['tour_location_id'] ?>"
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
                        <td colspan="7" class="text-center py-4 text-muted">
                            No locations found
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>
    </div>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>