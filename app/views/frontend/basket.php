<?php
include __DIR__ . '/inc/header.php';
include __DIR__ . '/inc/message.php';

$isLoggedIn   = isset($_SESSION['username']);
$reservations = $_SESSION['basket'] ?? [];
?>

<link rel="stylesheet" href="/frontend/css/basket.css" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="basket-container">
    <div class="basket">
        <h2>Shopping Cart</h2>

        <?php if (!empty($cartItems)) : ?>
            <table>
                <thead>
                    <tr>
                        <th>Type</th>
                        <th>Details</th>
                        <th>Quantity</th>
                        <th>Total Cost</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($cartItems as $index => $item) : ?>
                        <?php
                        $type = '';
                        $details = '';
                        $quantity = '';

                        if (isset($item['reservation_date'])) {
                            $type = 'Reservation';
                            $details = htmlspecialchars($item['name']) . ' - ' . htmlspecialchars($item['reservation_date']);
                            $quantity = htmlspecialchars($item['total_adult'] + $item['total_children']);
                        } elseif (isset($item['ticketType'])) {
                            $type = 'History Ticket';
                            $details = htmlspecialchars($item['start_location']) . ' - ' . htmlspecialchars($item['timeslot']);
                            $quantity = htmlspecialchars($item['participants']);
                        } elseif (isset($item['music_performance_id'])) {
                            $type = 'Dance Ticket';
                            $details = htmlspecialchars($item['event_name']) . ' - ' . htmlspecialchars($item['event_date']);
                            $quantity = htmlspecialchars($item['quantity']);
                        } elseif (isset($item['passType'])) {
                            $type = 'Dance Pass';
                            $details = htmlspecialchars($item['passName']) . ' - ' . htmlspecialchars($item['passDescription']);
                            $quantity = htmlspecialchars($item['quantity']);
                        }
                        ?>

                        <tr>
                            <td class="item-box"><?= $type; ?></td>
                            <td class="item-box"><?= $details; ?></td>
                            <td class="item-box"><?= $quantity; ?></td>
                            <td class="item-box"><?= htmlspecialchars($item['cost']); ?> EUR</td>
                            <td class="item-box">
                                <button class="remove-btn" data-index="<?= $index; ?>">Remove</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        <?php else : ?>
            <div class="cart">
                <p class="cartText">Your Shopping Cart is empty!</p>
                <a class="buy-btn" href="/home">Buy Now</a>
            </div>
        <?php endif; ?>
    </div>

    <div class="summary">
        <?php if (!empty($reservations)) : ?>
            <?php
            $subTotal = array_sum(array_column($reservations, 'cost'));
            $vat = $subTotal * 0.21;
            $total = $subTotal + $vat;
            ?>

            <div class="total-box">
                <p id="header-total">Total</p>
                <br>
                <p>Sub-total: €<?= number_format($subTotal, 2); ?></p>
                <p>21% VAT: €<?= number_format($vat, 2); ?></p>
                <p>Total: <strong>€<?= number_format($total, 2); ?></strong></p>

                <button class="checkout-btn">Check Out</button>

                <div class="accepted-payments">
                    <p>We accept:</p>
                    <img src="/images/ideal.png" alt="iDEAL">
                    <img src="/images/visa.png" alt="Visa">
                    <img src="/images/master.png" alt="MasterCard">
                    <img src="/images/paypal.png" alt="PayPal">
                </div>
            </div>

            <?php if (!$isLoggedIn) : ?>
                <div class="create-account-box">
                    <button class="create-account-btn">Create an Account</button>
                    <p>Create an account so you can <strong>save your personal program</strong> for later.</p>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<?php include __DIR__ . '/inc/footer.php'; ?>

<script>
    const basket = <?= json_encode($reservations); ?>;

    $(document).ready(function () {
        $('.remove-btn').on('click', function () {
            const index = $(this).data('index');
            window.location.href = '/personalprogram/removeItem?index=' + index;
        });

        $('.checkout-btn').on('click', function () {
            window.location.href = '/personalprogram/checkout';
        });

        $('.create-account-btn').on('click', function () {
            window.location.href = '/login/signup';
        });
    });
</script>