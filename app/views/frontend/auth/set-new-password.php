<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="/images/fav.png">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/frontend/css/login.css">

    <title>Reset Password</title>
</head>

<body class="login-page">

<div class="login-wrapper">
    <div class="login-card">

        <h3 class="login-title">Set New Password</h3>
        <p class="login-subtitle">Create a new secure password</p>

        <?php include __DIR__ . '/../inc/message.php'; ?>

        <form id="resetPasswordForm" method="POST" autocomplete="off">

            <!-- New Password -->
            <div class="form-group">
                <label>New Password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input type="password" class="form-control" name="password" id="password" required>
                </div>
            </div>

            <!-- Confirm Password -->
            <div class="form-group mt-3">
                <label>Confirm Password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock-fill"></i>
                    </span>
                    <input type="password" class="form-control" name="confirm_password" id="confirmPassword" required>
                </div>
            </div>

            <!-- Error Message -->
            <small id="passwordMismatchMessage" class="text-danger d-block mt-2"></small>

            <!-- Submit -->
            <button type="submit" class="btn login-btn mt-4 w-100">
                Update Password
            </button>

            <!-- Back -->
            <div class="login-links mt-3">
                <a href="/login/login">Back to Login ?</a>
            </div>

        </form>

    </div>
</div>

<footer class="login-footer">
    <p>&copy; <?= date('Y') ?> The Festival. All rights reserved.</p>
</footer>

<script>
document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {

    let pass = document.getElementById('password').value;
    let confirm = document.getElementById('confirmPassword').value;
    let msg = document.getElementById('passwordMismatchMessage');

    if (pass !== confirm) {
        e.preventDefault();
        msg.textContent = "Passwords do not match";
    } else {
        msg.textContent = "";
    }
});
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>