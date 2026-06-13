<?php
include __DIR__ . '/inc/header.php';

$isLoggedIn   = isset($_SESSION['username']);
$reservations = $_SESSION['basket'] ?? [];
$cartItems    = $reservations;

$totalItems = count($cartItems);

?>

<link rel="stylesheet" href="/frontend/css/basket.css" />

<div class="basket-container">

   
    <!-- ── CART PANEL ─────────────────────────────────────── -->
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
                            <!-- Type -->
                            <td class="item-box" data-label="Type">
                                <?php
                                if (isset($item['reservation_date']))     echo 'Reservation';
                                elseif (isset($item['ticketType']))        echo 'History Ticket';
                                elseif (isset($item['music_performance_id'])) echo 'Dance Ticket';
                                elseif (isset($item['passType']))          echo 'Dance Pass';
                                ?>
                            </td>

                            <!-- Details -->
                            <td class="item-box" data-label="Details">
                                <?php
                                if (isset($item['reservation_date'])) {
                                    echo htmlspecialchars($item['restaurant_name']) . ' — ' . htmlspecialchars($item['reservation_date']);
                                } elseif (isset($item['ticketType'])) {
                                    echo htmlspecialchars($item['start_location']) . ' — ' . htmlspecialchars($item['timeslot']);
                                } elseif (isset($item['music_performance_id'])) {
                                    echo htmlspecialchars($item['event_name']) . ' — ' . htmlspecialchars($item['event_date']);
                                } elseif (isset($item['passType'])) {
                                    echo htmlspecialchars($item['passName']) . ' — ' . htmlspecialchars($item['passDescription']);
                                }
                                ?>
                            </td>

                            <!-- Quantity -->
                            <td class="item-box" data-label="Quantity">
                                <?php
                                if (isset($item['total_adult'])) {
                                    echo htmlspecialchars($item['total_adult'] + $item['total_children']);
                                } elseif (isset($item['participants'])) {
                                    echo htmlspecialchars($item['participants']);
                                } elseif (isset($item['quantity'])) {
                                    echo htmlspecialchars($item['quantity']);
                                }
                                ?>
                            </td>

                            <!-- Cost -->
                            <td class="item-box" data-label="Total Cost">
                                €<?php echo number_format($item['cost'], 2); ?>
                            </td>

                            <!-- Action -->
                            <td class="item-box" data-label="Actions">
                                <button class="remove-btn" data-index="<?php echo $index; ?>">Remove</button>
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

    <!-- ── SUMMARY PANEL ──────────────────────────────────── -->
    <div class="summary">

        
            <?php
                $subTotal = array_sum(array_column($reservations, 'cost'));
                $vat      = $subTotal * 0.09;
                $total    = $subTotal + $vat;
            ?>
            <div class="total-box">
                <p id="header-total">Order Summary</p>

                <p><span>Subtotal</span> <span>€<?= number_format($subTotal, 2) ?></span></p>
                <p><span>VAT (9%)</span> <span>€<?= number_format($vat, 2) ?></span></p>
                <p><span><strong>Total</strong></span> <strong>€<?= number_format($total, 2) ?></strong></p>

            
                <button class="checkout-btn" data-reservations=<? echo$totalItems ?> >Check Out</button>
 
                <div class="accepted-payments">
                    <p>We accept</p>
                    <img src="/images/overview/payment.png" alt="Accepted payment methods" />
                </div>
            </div>


            <?php if (!$isLoggedIn) : ?>
                <div class="create-account-box">
                    <button class="create-account-btn">Create an Account</button>
                    <p>Save your <strong>personal program</strong> for later by creating a free account.</p>
                </div>
            <?php endif; ?>

     
    </div>


</div>
<?php include __DIR__ . '/inc/footer.php'; ?>

<script>
    $(document).ready(function () {

        $('.remove-btn').on('click', function () {
            const index = $(this).data('index');
            window.location.href = '/personalprogram/removeItem?index=' + index;
        });

        $('.checkout-btn').on('click', function () {

            let totalItems = $(this).attr('data-reservations');
            if(totalItems == 0){ 
                toastr.error('You have no reservations in your cart!');
                return;
            }
            window.location.href = '/personalprogram/checkout';
        });

        $('.create-account-btn').on('click', function () {
            window.location.href = '/login/signup';
        });

    });
</script>
