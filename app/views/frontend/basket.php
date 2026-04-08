<?php
include __DIR__ . '/inc/header.php';
include __DIR__ . '/inc/message.php';

$isLoggedIn   = isset($_SESSION['username']);
$reservations = $_SESSION['basket'] ?? [];
$calculateLineTotal = static function(array $item): float {
    if (isset($item['reservation_date'])) {
        $adults = (int) ($item['total_adult'] ?? 0);
        $children = (int) ($item['total_children'] ?? 0);
        $costPerPerson = (float) ($item['cost_per_person'] ?? 0);

        return $costPerPerson * ($adults + $children);
    }

    if (isset($item['music_performance_id'])) {
        return (float) ($item['event_price'] ?? 0) * max(1, (int) ($item['quantity'] ?? 1));
    }

    if (isset($item['passType'])) {
        return (float) ($item['passPrice'] ?? $item['cost'] ?? 0) * max(1, (int) ($item['quantity'] ?? 1));
    }

    return (float) ($item['cost'] ?? 0);
};

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
                    <tr>
                        <td class="item-box">
                            <?php
                            if (isset($item['reservation_date'])) {
                                echo 'Reservation';
                            } elseif (isset($item['ticketType'])) {
                                echo 'History Ticket';
                            } elseif (isset($item['music_performance_id'])) {
                                echo 'Dance Ticket';
                            } elseif (isset($item['passType'])) {
                                echo 'Dance Pass';
                            }
                            ?>
                        </td>
                        <td class="item-box">
                            <?php
                            if (isset($item['reservation_date'])) {
                                echo htmlspecialchars($item['name']) . ' - ' . htmlspecialchars($item['reservation_date']);
                            } elseif (isset($item['ticketType'])) {
                                echo htmlspecialchars($item['start_location']) . ' - ' . htmlspecialchars($item['timeslot']);
                            } elseif (isset($item['music_performance_id'])) {
                                echo htmlspecialchars($item['event_name']) . ' - ' . htmlspecialchars($item['event_date']);
                            } elseif (isset($item['passType'])) {
                                echo htmlspecialchars($item['passName']) . ' - ' . htmlspecialchars($item['passDescription']);
                            }
                            ?>
                        </td>
                        <td class="item-box">
                            <?php
                            if (isset($item['total_adult'])) {
                                echo htmlspecialchars($item['total_adult'] + $item['total_children']);
                            } elseif (isset($item['ticketType'])) {
                                echo htmlspecialchars($item['participants']);
                            } elseif (isset($item['music_performance_id'])) {
                                echo htmlspecialchars($item['quantity']);
                            } elseif (isset($item['passType'])) {
                                echo htmlspecialchars($item['quantity']);
                            }
                            ?>
                        </td>
                        <td class="item-box"><?php echo htmlspecialchars(number_format($calculateLineTotal($item), 2)); ?> EUR</td>
                        <td class="item-box"><button class="remove-btn" data-index="<?php echo $index; ?>">Remove</button></td>
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
                <div class="total-box">
                <?php
                $subTotal = array_reduce(
                    $reservations,
                    static function ($sum, $item) use ($calculateLineTotal) {
                        return $sum + $calculateLineTotal($item);
                    },
                    0
                );
                $vat = $subTotal * 0.21;
                $total = $subTotal + $vat;
                ?>
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