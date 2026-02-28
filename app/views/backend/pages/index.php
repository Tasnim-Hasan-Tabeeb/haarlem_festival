<?php
include __DIR__ . '/../inc/header.php';
?>

<div class="container">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <div class="d-flex justify-content-between align-items-center">
        <h1>Page List</h1>
        <a href="/page/create" class="btn btn-success">Add page</a>
    </div>
    <?php include __DIR__ . '/../inc/message.php'; ?>
    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Page Title</th>
                    <th>Enable</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($pages) > 0) { ?>
                    <?php foreach ($pages as $page) : ?>
                        <tr>
                            <td><?= $page['page_id'] ?></td>
                            <td><?= $page['title'] ?></td>
                            <td>
                                <input type="checkbox" class="page-switch" data-id="<?php echo $page['page_id']; ?>" <?php echo $page['active'] ? 'checked' : ''; ?>>
                            </td>
                            <td>
                                <a href="/page/edit?id=<?= $page['page_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $page['page_id'] ?>">Delete</button>
                                <div class="modal fade" id="deleteModal<?= $page['page_id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $page['page_id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel<?= $page['page_id'] ?>">Confirm Deletion</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this page?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <a href="/page/delete?id=<?= $page['page_id'] ?>" class="btn btn-danger">Delete</a>
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