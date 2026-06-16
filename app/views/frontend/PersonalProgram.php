<?php
include __DIR__ . '/inc/header.php';

$reservations = $_SESSION['basket'] ?? [];
?>

<link rel="stylesheet" href="/frontend/css/PersonalProgram.css" />

<div class="personal-program-page">
    <div class="personal-program-container">

        <!-- Header row: label + CTA -->
       <div class="checkout-row">
            <p class="checkoutText">
                Do you want to Checkout? Go to your Shopping Cart ➡️
            </p>

            <div class="checkout-actions">
                <a class="continue-shopping-btn" href="/">
                    ← Continue Shopping
                </a>

                <a class="checkout-btn" href="/personalprogram/basket">
                    Shopping Cart
                </a>
            </div>
        </div>
        <!-- Section heading -->
        <div class="view-container">
            <p class="listViewText">List View</p>
        </div>

        <!-- Items rendered by JS -->
        <div class="list-view active" id="list-view"></div>

    </div>
</div>

<script>
    window.personalProgramReservations = <?= json_encode(
        $reservations,
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    ) ?>;
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/frontend/js/personal-program.js"></script>

<?php include __DIR__ . '/inc/footer.php'; ?>