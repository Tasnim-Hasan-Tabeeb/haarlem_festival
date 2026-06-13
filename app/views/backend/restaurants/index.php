<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container">

    <div class="d-flex justify-content-between align-items-center">
        <h1>Restaurant List</h1>
        <a href="/restaurant/create" class="btn btn-success">Add Restaurant</a>
    </div>

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover align-middle text-nowrap">

            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Image</th>
                    <th>Rating</th>
                    <th>Price</th>
                    <th>Cuisines</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($restaurants)) : ?>
                    <?php foreach ($restaurants as $restaurant) : ?>
                        <tr>

                            <td><?= htmlspecialchars($restaurant['title']) ?></td>

                            <td>
                                <img src="<?= htmlspecialchars($restaurant['image_url']) ?>"
                                     alt="restaurant image"
                                     class="img-thumbnail"
                                     width="70"
                                     height="70">
                            </td>

                            <td>
                                <?= htmlspecialchars($restaurant['ratings']) ?> ★
                            </td>

                            <td>
                                <div>👶 Child: <?= number_format($restaurant['price_for_child'], 2) ?></div>
                                <div>🧑 Adult: <?= number_format($restaurant['price_for_adult'], 2) ?></div>
                            </td>

                            <td><?= htmlspecialchars($restaurant['cuisines']) ?></td>

                            <td><?= htmlspecialchars($restaurant['location']) ?></td>

                            <td>
                                <div class="btn-group btn-group-sm" role="group">

                                    <a href="/restaurant/view?id=<?= $restaurant['restaurant_id'] ?>"
                                       class="btn btn-info">
                                        View
                                    </a>

                                    <a href="/restaurant/edit?id=<?= $restaurant['restaurant_id'] ?>"
                                       class="btn btn-primary">
                                        Edit
                                    </a>

                                    <button type="button"
                                            class="btn btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal<?= $restaurant['restaurant_id'] ?>">
                                        Delete
                                    </button>

                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade"
                                     id="deleteModal<?= $restaurant['restaurant_id'] ?>"
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
                                                Are you sure you want to delete this restaurant?
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                                <a href="/restaurant/delete?id=<?= $restaurant['restaurant_id'] ?>"
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
                        <td colspan="7" class="text-center py-4">
                            No Restaurants Found
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>
    </div>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>