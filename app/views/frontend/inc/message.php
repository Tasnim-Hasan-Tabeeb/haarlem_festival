<?php if (isset($_SESSION['isError']) && !$_SESSION['isError']) { ?>

    <div>
        <?php if (isset($_SESSION['flash_message'])) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong><?= $_SESSION['isError'] ? 'Error!' : 'Success!' ?></strong> <?= $_SESSION['flash_message'] ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['flash_message']); ?>
        <?php endif; ?>
    </div>

<?php } else { ?>

    <div>
        <?php if (isset($_SESSION['flash_message'])) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong><?= $_SESSION['isError'] ? 'Error!' : 'Success!' ?></strong> <?= $_SESSION['flash_message'] ?>
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


<?php

$validationErrors = $_SESSION['validation_errors'] ?? [];
unset($_SESSION['validation_errors']);

if (!function_exists('flattenErrors')) {
    function flattenErrors($errors)
    {
        $result = [];

        foreach ($errors as $key => $error) {
            if (is_array($error)) {
                $result = array_merge($result, flattenErrors($error));
            } else {
                $result[$key] = $error;
            }
        }

        return $result;
    }
}

$flatErrors = flattenErrors($validationErrors);

?>

<?php if (!empty($flatErrors)): ?>
    <?php foreach ($flatErrors as $key => $error): ?>

        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>
                Error<?= is_string($key) ? " [$key]" : '' ?>!
            </strong>
            <?= htmlspecialchars($error) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>

    <?php endforeach; ?>
<?php endif; ?>


