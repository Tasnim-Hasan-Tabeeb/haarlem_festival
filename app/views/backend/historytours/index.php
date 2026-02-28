<?php
include __DIR__ . '/../inc/header.php';
?>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center">
            <h1>Tours</h1>
            <a href="/historytour/create" class="btn btn-success">Add Tour</a>
        </div>
        <?php include __DIR__ . '/../inc/message.php'; ?>
        <div class="table-responsive mt-4">
            <table class="table table-striped table-hover">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Language</th>
                    <th>Available Guides</th>
                    <th>Flag</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($tours as $tour) : ?>
                    <tr>
                        <td><?= $tour['date'] ?></td>
                        <td><?= $tour['start_time'] ?></td>
                        <td><?= $tour['end_time'] ?></td>
                        <td><?= $tour['language_name']?></td>
                        <td><?= $tour['available_guides']?></td>
                        <td><img src="<?='/images/' . $tour['flag_image']?>" alt="<?= $tour['language_name']?>" style="width: 100px"></td>
                        <td>
                            <a href="/historytours/edit?id=<?= $tour['tour_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                            <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $tour['tour_id'] ?>">Delete</button>
                            <div class="modal fade" id="deleteModal<?= $tour['tour_id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $tour['tour_id'] ?>" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="deleteModalLabel<?= $tour['tour_id'] ?>">Confirm Deletion</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete this page?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <a href="/historytours/delete?id=<?= $tour['tour_id'] ?>" class="btn btn-danger">Delete</a>
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