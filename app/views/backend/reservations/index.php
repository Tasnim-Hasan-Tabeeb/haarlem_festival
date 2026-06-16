<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container">

    <div class="d-flex justify-content-between align-items-center">
        <h1>Reservation List</h1>
        <a href="/reservation/create" class="btn btn-success">Add Reservation</a>
    </div>

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover align-middle text-nowrap">

            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Adults</th>
                    <th>Children</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Status Action</th>
                    <th>Actions</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($reservations)) : ?>
                    <?php foreach ($reservations as $reservation) : ?>

                        <tr>
                            <td><?= htmlspecialchars($reservation['reservation_id']) ?></td>
                            <td><?= htmlspecialchars($reservation['name']) ?></td>
                            <td><?= htmlspecialchars($reservation['reservation_date']) ?></td>
                            <td><?= htmlspecialchars($reservation['total_adult']) ?></td>
                            <td><?= htmlspecialchars($reservation['total_children']) ?></td>
                            <td><?= htmlspecialchars($reservation['email']) ?></td>
                            <td><?= htmlspecialchars($reservation['phone']) ?></td>

                            <td>
                                <?php if ($reservation['is_active']) : ?>
                                    <span class="badge bg-success">Active</span>
                                <?php else : ?>
                                    <span class="badge bg-secondary">Inactive</span>
                                <?php endif; ?>
                            </td>

                            <td>
                                <?php if ($reservation['is_active']) : ?>
                                    <form action="/reservation/updateIsActiveToZero" method="post">
                                        <input type="hidden" name="reservation_id"
                                            value="<?= $reservation['reservation_id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-warning">
                                            Deactivate
                                        </button>
                                    </form>
                                <?php else : ?>
                                    <form action="/reservation/updateIsActiveToOne" method="post">
                                        <input type="hidden" name="reservation_id"
                                            value="<?= $reservation['reservation_id'] ?>">
                                        <button type="submit" class="btn btn-sm btn-outline-success">
                                            Activate
                                        </button>
                                    </form>
                                <?php endif; ?>
                            </td>


                            <td>
                                <div class="btn-group btn-group-sm" role="group">

                                    <a href="/reservation/show?id=<?= $reservation['reservation_id'] ?>"
                                       class="btn btn-info">
                                        View
                                    </a>

                                    <a href="/reservation/edit?id=<?= $reservation['reservation_id'] ?>"
                                       class="btn btn-primary">
                                        Edit
                                    </a>

                                  

                                    <button type="button"
                                            class="btn btn-danger"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteModal<?= $reservation['reservation_id'] ?>">
                                        Delete
                                    </button>



                                </div>

                                <!-- Delete Modal -->
                                <div class="modal fade"
                                     id="deleteModal<?= $reservation['reservation_id'] ?>"
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
                                                Are you sure you want to delete this reservation?
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button"
                                                        class="btn btn-secondary"
                                                        data-bs-dismiss="modal">
                                                    Cancel
                                                </button>

                                                <a href="/reservation/delete?id=<?= $reservation['reservation_id'] ?>"
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
                        <td colspan="9" class="text-center py-4">
                            No reservations found
                        </td>
                    </tr>
                <?php endif; ?>

            </tbody>

        </table>
    </div>

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>