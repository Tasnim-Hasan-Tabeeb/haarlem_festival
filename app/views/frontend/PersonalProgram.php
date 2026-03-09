<?php
include __DIR__ . '/inc/header.php';
include __DIR__ . '/inc/message.php';

$reservations = $_SESSION['basket'] ?? [];
?>

<link rel="stylesheet" href="/frontend/css/PersonalProgram.css"/>

<div class="personal-program-page">
    <div class="personal-program-container">
        <p class="checkoutText">Do you want to Checkout? Go to your Shopping Cart ➡️</p>
        <a class="checkout-btn" href="/personalprogram/basket">Shopping Cart</a>

        <div class="view-container">
            <p class="listViewText">List View</p>
        </div>

        <div class="list-view active" id="list-view"></div>
    </div>
</div>

<script>
    window.personalProgramReservations = <?= json_encode($reservations, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
</script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="/frontend/js/personal-program.js"></script>

<?php include __DIR__ . '/inc/footer.php'; ?>
