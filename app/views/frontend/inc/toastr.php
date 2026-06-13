<!-- TOASTR OUTPUT -->
<script>

<?php if (isset($_SESSION['flash_message'])): ?>
    
    <?php if (isset($_SESSION['isError']) && $_SESSION['isError']): ?>
        toastr.error("<?= addslashes($_SESSION['flash_message']) ?>");
    <?php else: ?>
        toastr.success("<?= addslashes($_SESSION['flash_message']) ?>");
    <?php endif; ?>

    <?php unset($_SESSION['flash_message'], $_SESSION['isError']); ?>

<?php endif; ?>

<?php
$errors = $_SESSION['errors'] ?? [];
unset($_SESSION['errors']);
?>

<?php if (!empty($errors)): ?>
    <?php foreach ($errors as $error): ?>
        toastr.error("<?= addslashes($error) ?>");
    <?php endforeach; ?>
<?php endif; ?>


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
                $result[] = $error; // cleaner for toast
            }
        }

        return $result;
    }
}

$flatErrors = flattenErrors($validationErrors);
?>

<?php if (!empty($flatErrors)): ?>
    <?php foreach ($flatErrors as $error): ?>
        toastr.error("<?= addslashes($error) ?>");
    <?php endforeach; ?>
<?php endif; ?>

</script>