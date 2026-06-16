<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">User List</h1>
        <a href="/user/create" class="btn btn-success">Add User</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle text-nowrap">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Registration Date</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($users)) : ?>

                    <?php foreach ($users as $user) : ?>
                        <tr>

                            <td><?= htmlspecialchars($user['user_id']) ?></td>

                            <td><?= htmlspecialchars($user['name']) ?></td>

                            <td><?= htmlspecialchars($user['email']) ?></td>

                            <td><?= htmlspecialchars($user['role']) ?></td>

                            <td>
                                <?= date('Y-m-d h:i A', strtotime($user['registration_date'])) ?>
                            </td>

                            <td>
                                <div class="btn-group btn-group-sm" role="group">

                                    <a href="/user/edit?id=<?= $user['user_id'] ?>"
                                       class="btn btn-primary">
                                        Edit
                                    </a>

                                    <button type="button"
                                            class="btn btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal<?= $user['user_id'] ?>">
                                        Delete
                                    </button>

                                </div>

                                <!-- Modal -->
                                <div class="modal fade"
                                     id="deleteModal<?= $user['user_id'] ?>"
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
                                                Are you sure you want to delete this user?
                                            </div>

                                            <div class="modal-footer">

                                                <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                                <a href="/user/delete?id=<?= $user['user_id'] ?>"
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
                            No users found
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>
    </div>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>