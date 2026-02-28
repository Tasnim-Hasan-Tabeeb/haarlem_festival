<?php
include __DIR__ . '/../inc/header.php';
?>
<div class="container">
    <?php include __DIR__ . '/../inc/message.php'; ?>
    <div class="d-flex justify-content-between align-items-center">
        <h1>Orders List</h1>
    </div>
    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover">
            <tr>
                <th>Order ID</th>
                <th>Total Amount</th>
                <th>Created At</th>
                <th>Updated At</th>
                <th>Item Type</th>
                <th>Customer Name</th>
                <th>Event Name</th>
            </tr>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= isset($order['order_id']) ? htmlspecialchars($order['order_id']) : '' ?></td>
                    <td><?= isset($order['total_amount']) ? htmlspecialchars($order['total_amount']) : '' ?></td>
                    <td><?= isset($order['created_at']) ? htmlspecialchars($order['created_at']) : '' ?></td>
                    <td><?= isset($order['updated_at']) ? htmlspecialchars($order['updated_at']) : '' ?></td>
                    <td><?= isset($order['item_type']) ? htmlspecialchars($order['item_type']) : '' ?></td>
                    <td><?= isset($order['customer_name']) ? htmlspecialchars($order['customer_name']) : '' ?></td>
                    <td><?= isset($order['event_name']) ? htmlspecialchars($order['event_name']) : '' ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <div class="mt-3">
            <a href="/manageorders/exportOrdersToCSV" class="btn btn-primary">Export to CSV</a>
            <a href="/manageorders/exportOrdersToExcel" class="btn btn-success">Export to Excel</a>
        </div>
    </div>
</div>

