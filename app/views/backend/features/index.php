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
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($features) > 0) { ?>
                    <?php foreach ($features as $feature) : ?>
                        <tr>
                            <td><?= $feature['feature_id'] ?></td>
                            <td>
                                <img src="<?= $feature['image_url'] ?>" alt="image" width="80" height="80">
                            </td>
                            <td><?= $feature['name'] ?></td>
                            <td>
                                <a href="/feature/edit?id=<?= $feature['feature_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $feature['feature_id'] ?>">Delete</button>
                                <div class="modal fade" id="deleteModal<?= $feature['feature_id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $feature['feature_id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel<?= $feature['feature_id'] ?>">Confirm Deletion</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this feature?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <a href="/feature/delete?id=<?= $feature['feature_id'] ?>" class="btn btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <tr>
                        <td class="text-center" colspan="4">No Content</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php
include __DIR__ . '/../inc/footer.php';
?>