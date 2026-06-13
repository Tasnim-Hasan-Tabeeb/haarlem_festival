<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">History Page Content</h1>
        <a href="/historyinformation/create" class="btn btn-success">Add Content</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th style="min-width: 250px;">Description</th>
                    <th>Image</th>
                    <th>URL</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($contents)) : ?>

                    <?php foreach ($contents as $content) : ?>
                        <tr>

                            <td><?= htmlspecialchars($content['content_id']) ?></td>

                            <td><?= htmlspecialchars($content['title']) ?></td>

                            <td>
                                <?= htmlspecialchars(mb_strimwidth($content['description'], 0, 120, '...')) ?>
                            </td>

                            <td>
                                <?php if (!empty($content['image'])) : ?>
                                    <img src="<?= htmlspecialchars($content['image']) ?>"
                                         alt="Content Image"
                                         class="img-thumbnail"
                                         width="80"
                                         height="80">
                                <?php else : ?>
                                    <span class="text-muted">No Image</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if (!empty($content['url'])) : ?>
                                    <a href="<?= htmlspecialchars($content['url']) ?>"
                                       target="_blank"
                                       class="text-decoration-none">
                                        View
                                    </a>
                                <?php else : ?>
                                    <span class="text-muted">---</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <div class="btn-group btn-group-sm" role="group">

                                    <a href="/historyinformation/edit?id=<?= $content['content_id'] ?>"
                                       class="btn btn-primary">
                                        Edit
                                    </a>

                                    <button type="button"
                                            class="btn btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal<?= $content['content_id'] ?>">
                                        Delete
                                    </button>

                                </div>

                                <!-- Modal -->
                                <div class="modal fade"
                                     id="deleteModal<?= $content['content_id'] ?>"
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
                                                Are you sure you want to delete this content?
                                            </div>

                                            <div class="modal-footer">

                                                <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                                <a href="/historyinformation/delete?id=<?= $content['content_id'] ?>"
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
                            No content found
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>
    </div>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>