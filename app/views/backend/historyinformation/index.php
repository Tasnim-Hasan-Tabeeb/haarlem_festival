<?php
include __DIR__ . '/../inc/header.php';
?>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>History Page Content</h1>
            <a href="/historyinformation/create" class="btn btn-success">Add Content</a>
        </div>
        <?php include __DIR__ . '/../inc/message.php'; ?>
        <div class="table-responsive mt-4">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th style="min-width: 300px;">Description</th>
                    <th>Image</th>
                    <th>Url</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($contents as $content) : ?>
                    <tr>
                        <td><?= $content['content_id'] ?></td>
                        <td><?= $content['title'] ?></td>
                        <td><?= $content['description'] ?></td>
                        <td>
                            <?php if(!empty($content['image'])){?>
                            <img src="<?='/images/' . $content['image']?>" alt="image" style="width: 100px">
                            <?php }?>
                        </td>
                        <td><?= $content['url']?></td>
                        <td>
                            <a href="/historyinformation/edit?id=<?= $content['content_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $content['content_id'] ?>">Delete</button>
                            <div class="modal fade" id="deleteModal<?= $content['content_id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $content['content_id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel<?= $content['content_id'] ?>">Confirm Deletion</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this page?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <a href="/historyinformation/delete?id=<?= $content['content_id'] ?>" class="btn btn-danger">Delete</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <?php ?>
                </tbody>
            </table>
        </div>
    </div>

<?php
include __DIR__ . '/../inc/footer.php';
?>