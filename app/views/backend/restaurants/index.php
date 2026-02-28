<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Restaurant List</h1>
        <a href="/restaurant/create" class="btn btn-success">Add Restaurant</a>
    </div>

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Rating</th>
                    <th>Cuisines</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($restaurants) > 0) { ?>
                    <?php foreach ($restaurants as $restaurant) : ?>
                        <tr>
                            <td><?= $restaurant['title'] ?></td>
                            <td><img src="<?= $restaurant['image_url'] ?>" alt="Restaurant Image" style="width: 100px;"></td>
                            <td><?= $restaurant['ratings'] ?> star</td>
                            <td><?= $restaurant['cuisines'] ?></td>
                            <td><?= $restaurant['location'] ?></td>
                            <td>
                                <a href="/restaurant/view?id=<?= $restaurant['restaurant_id'] ?>" class="btn btn-info btn-sm">View</a>
                                <a href="/restaurant/edit?id=<?= $restaurant['restaurant_id'] ?>" class="btn btn-primary btn-sm">Edit</a>
                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $restaurant['restaurant_id'] ?>">Delete</button>
                                <div class="modal fade" id="deleteModal<?= $restaurant['restaurant_id'] ?>" tabindex="-1" aria-labelledby="deleteModalLabel<?= $restaurant['restaurant_id'] ?>" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel<?= $restaurant['restaurant_id'] ?>">Confirm Deletion</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete this restaurant?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <a href="/restaurant/delete?id=<?= $restaurant['restaurant_id'] ?>" class="btn btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <tr>
                        <td class="text-center" colspan="7">No Restaurants Found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>