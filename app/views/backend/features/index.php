<?php
include __DIR__ . '/../inc/header.php';
?>

<div class="container">

    <div class="d-flex justify-content-between align-items-center">
        <h1>Feature List</h1>
        <a href="/feature/create" class="btn btn-success">Add Feature</a>
    </div>

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover align-middle text-nowrap">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($features)) : ?>
                    <?php foreach ($features as $feature) : ?>
                        <tr>

                            <td><?= htmlspecialchars($feature['feature_id']) ?></td>

                            <td>
                                <img src="<?= htmlspecialchars($feature['image_url']) ?>"
                                     alt="feature image"
                                     class="img-thumbnail"
                                     width="70"
                                     height="70">
                            </td>

                            <td><?= htmlspecialchars($feature['name']) ?></td>

                            <td>
                                <div class="btn-group btn-group-sm" role="group">

                                    <a href="/feature/edit?id=<?= $feature['feature_id'] ?>"
                                       class="btn btn-primary">
                                        Edit
                                    </a>

                                    <button type="button"
                                            class="btn btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal<?= $feature['feature_id'] ?>">
                                        Delete
                                    </button>

                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade"
                                     id="deleteModal<?= $feature['feature_id'] ?>"
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
                                                Are you sure you want to delete this feature?
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                                <a href="/feature/delete?id=<?= $feature['feature_id'] ?>"
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
                        <td colspan="4" class="text-center py-4">
                            No features found
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>

        </table>
    </div>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>