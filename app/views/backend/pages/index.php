<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Page List</h1>
        <a href="/page/create" class="btn btn-success">Add Page</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle text-nowrap">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Page Title</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php if (!empty($pages)) : ?>
                    <?php foreach ($pages as $page) : ?>
                        <tr>
                            <td><?= htmlspecialchars($page['page_id']) ?></td>

                            <td>
                                <?= htmlspecialchars($page['title']) ?>
                            </td>

                            <td>
                                <div class="form-check form-switch m-0">
                                    <input type="checkbox"
                                           class="form-check-input page-switch"
                                           data-id="<?= $page['page_id'] ?>"
                                           <?= $page['active'] ? 'checked' : '' ?>>
                                </div>
                            </td>

                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="/page/edit?id=<?= $page['page_id'] ?>" class="btn btn-primary">
                                        Edit
                                    </a>

                                    <?php if ($page['slug'] !== 'home') : ?>
                                        <button type="button"
                                                class="btn btn-danger"
                                                data-bs-toggle="modal"
                                                data-bs-target="#deleteModal<?= $page['page_id'] ?>">
                                            Delete
                                        </button>
                                    <?php endif; ?>
                                </div>

                                <!-- Modal -->
                                <div class="modal fade"
                                     id="deleteModal<?= $page['page_id'] ?>"
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
                                                Are you sure you want to delete this page?
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                                <a href="/page/delete?id=<?= $page['page_id'] ?>"
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
                        <td colspan="4" class="text-center py-4 text-muted">
                            No pages found
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>