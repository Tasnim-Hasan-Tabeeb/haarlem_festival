<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container">
    <div class="d-flex justify-content-between align-items-center">
        <h1>Reservation List</h1>
        <a href="/reservation/add" class="btn btn-success">Add Reservation</a>
    </div>

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Reservation Date</th>
                    <th>Total Adults</th>
                    <th>Total Children</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($reservations) > 0) { ?>
                    <?php foreach ($reservations as $reservation) : ?>
                        <tr>
                            <td><?= $reservation['reservation_id'] ?></td>
                            <td><?= htmlspecialchars($reservation['name']) ?></td>
                            <td><?= htmlspecialchars($reservation['reservation_date']) ?></td>
                            <td><?= htmlspecialchars($reservation['total_adult']) ?></td>
                            <td><?= htmlspecialchars($reservation['total_children']) ?></td>
                            <td><?= htmlspecialchars($reservation['email']) ?></td>
                            <td><?= htmlspecialchars($reservation['phone']) ?></td>
                            <td><?= $reservation['is_active'] ? 'Active' : 'Inactive' ?></td>
                            <td>
                                <a href="/reservation/show?id=<?= $reservation['reservation_id'] ?>" class="btn btn-info btn-sm">View</a>
                                <a href="/reservation/edit?id=<?= $reservation['reservation_id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <?php if ($reservation['is_active']) : ?>
                                    <form action="/reservation/updateIsActiveToZero" method="post" style="display:inline;">
                                        <input type="hidden" name="reservation_id" value="<?= $reservation['reservation_id'] ?>">
                                        <button type="submit" class="btn btn-warning btn-sm">Deactivate</button>
                                    </form>
                                <?php else : ?>
                                    <form action="/reservation/updateIsActiveToOne" method="post" style="display:inline;">
                                        <input type="hidden" name="reservation_id" value="<?= $reservation['reservation_id'] ?>">
                                        <button type="submit" class="btn btn-success btn-sm">Reactivate</button>
                                    </form>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <tr>
                        <td class="text-center" colspan="9">No Reservations Found</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>