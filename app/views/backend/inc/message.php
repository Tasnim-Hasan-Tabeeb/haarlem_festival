<?php if (isset($_SESSION['isError']) && !$_SESSION['isError']) { ?>

    <div>
        <?php if (isset($_SESSION['flash_message'])) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Success!</strong> <?= $_SESSION['flash_message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>
    </div>

<?php } else { ?>

    <div>
        <?php if (isset($_SESSION['flash_message'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Success!</strong> <?= $_SESSION['flash_message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>
    </div>

<?php } ?>

<?php

$errors = $_SESSION['errors'] ?? [];

unset($_SESSION['errors']);

if (!empty($errors)) {
    foreach ($errors as $error) {
        echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> ' . $error . '
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>';
    }
}

?>