<?php
include __DIR__ . '/../inc/header.php';
?>

<div class="container">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="h3 mb-0">Artist List</h1>
        <a href="/artist/create" class="btn btn-success">Add Artist</a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle text-nowrap">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Nationality</th>
                    <th>Genre</th>
                    <th>About</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($artists as $artist) : ?>
                    <tr>
                        <td><?= $artist['artist_id'] ?></td>

                        <td>
                            <img
                                src="<?=  $artist['image_url'] ?>"
                                alt="<?= $artist['artist_name'] ?>"
                                class="img-thumbnail rounded"
                                width="60"
                                height="60"
                            >
                        </td>

                        <td><?= htmlspecialchars($artist['artist_name']) ?></td>
                        <td><?= htmlspecialchars($artist['age']) ?></td>
                        <td><?= htmlspecialchars($artist['nationality']) ?></td>
                        <td><?= htmlspecialchars($artist['genre']) ?></td>
                        <td>
                            <span class="d-inline-block text-truncate" style="max-width: 250px;">
                                <?= htmlspecialchars($artist['about']) ?>
                            </span>
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm" role="group">
                                <a href="/artist/edit?id=<?= $artist['artist_id'] ?>" class="btn btn-primary">
                                    Edit
                                </a>

                                <button type="button"
                                        class="btn btn-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteModal<?= $artist['artist_id'] ?>">
                                    Delete
                                </button>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade"
                                 id="deleteModal<?= $artist['artist_id'] ?>"
                                 tabindex="-1"
                                 aria-hidden="true">

                                <div class="modal-dialog">
                                    <div class="modal-content">

                                        <div class="modal-header">
                                            <h5 class="modal-title">Confirm Deletion</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>

                                        <div class="modal-body">
                                            Are you sure you want to delete this artist?
                                        </div>

                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                Cancel
                                            </button>

                                            <a href="/artist/delete?id=<?= $artist['artist_id'] ?>"
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