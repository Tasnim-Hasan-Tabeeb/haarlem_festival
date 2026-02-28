<?php
include __DIR__ . '/../inc/header.php';
?>

    <div class="container">

        <?php include __DIR__ . '/../inc/message.php'; ?>


        <div class="d-flex justify-content-between align-items-center">
            <h1>Artist List</h1>
            <a href="/artist/create" class="btn btn-success">Add Artist</a>
        </div>
        <div class="table-responsive mt-4">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>Nationality</th>
                    <th>Genre</th>
                    <th>About</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($artists as $artist) : ?>
                    <tr>
                        <td><?= $artist['artist_id'] ?></td>
                        <td><img src="<?= '/images/' .  $artist['image_url'] ?>" alt="<?= $artist['artist_name'] ?>" style="width: 100px;"></td>
                        <td><?= $artist['artist_name'] ?></td>
                        <td><?= $artist['age'] ?></td>
                        <td><?= $artist['nationality'] ?></td>
                        <td><?= $artist['genre'] ?></td>
                        <td><?= $artist['about'] ?></td>
                        <td>
                            <a href="/artist/edit?id=<?= $artist['artist_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $artist['artist_id'] ?>">Delete</button>
                            <div class="modal fade" id="deleteModal<?= $artist['artist_id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $artist['artist_id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel<?= $artist['artist_id'] ?>">Confirm Deletion</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this artist?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <a href="/artist/delete?id=<?= $artist['artist_id'] ?>" class="btn btn-danger">Delete</a>
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