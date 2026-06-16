<?php include __DIR__ . '/../inc/header.php'; ?>

<div class="container">

    <?php include __DIR__ . '/../inc/message.php'; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">

        <!-- LEFT: TITLE -->
        <h1 class="h3 mb-0">Orders List</h1>

        <!-- RIGHT: ACTION BUTTONS -->
        <div class="d-flex gap-2">

            <a href="/manageorders/exportOrdersToCSV" class="btn btn-primary btn-sm">
                Export to CSV
            </a>

            <a href="/manageorders/exportOrdersToExcel" class="btn btn-success btn-sm">
                Export to Excel
            </a>

        </div>

    </div>


    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle text-nowrap">

            <thead class="table-dark">
                <tr>
                    <th>Order ID</th>
                    <th>Total Amount</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Item Type</th>
                    <th>Customer Name</th>
                    <th>Event Name</th>
                </tr>
            </thead>

            <tbody>

                <?php if (!empty($orders)) : ?>

                    <?php foreach ($orders as $order): ?>
                        <tr>

                            <td><?= htmlspecialchars($order['order_id'] ?? '') ?></td>

                            <td><?= htmlspecialchars($order['total_amount'] ?? '') ?></td>

                            <td><?= htmlspecialchars($order['created_at'] ?? '') ?></td>

                            <td><?= htmlspecialchars($order['updated_at'] ?? '') ?></td>

                            <td><?= htmlspecialchars($order['item_type'] ?? '---') ?></td>

                            <td><?= htmlspecialchars($order['customer_name'] ?? '---') ?></td>

                            <td><?= htmlspecialchars($order['event_name'] ?? '---') ?></td>

                        </tr>
                    <?php endforeach; ?>

                <?php else : ?>

                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            No orders found
                        </td>
                    </tr>

                <?php endif; ?>

            </tbody>

        </table>
    </div>

    <!-- Export Buttons -->
  

</div>

<?php include __DIR__ . '/../inc/footer.php'; ?>