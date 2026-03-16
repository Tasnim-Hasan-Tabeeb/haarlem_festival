<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set New Password</title>
    <link rel="icon" type="image/x-icon" href="/images/fav.png">
    <style>
        <?php include __DIR__ . '/../../../public/frontend/css/style.css'; ?>
    </style>
</head>
<body class="password-body">
<img src="/images/logo.png" alt="Logo" class="logo">

<div class="container-password">
    <h1>Set New Password</h1>
    <form id="resetPasswordForm" method="post">
        <label for="password">New Password:</label>
        <input type="password" id="password" name="password" required><br>
        <label for="confirmPassword">Confirm Password:</label>
        <input type="password" id="confirmPassword" name="confirmPassword" required><br>
        <span id="passwordMismatchMessage" class="password-mismatch-message"></span>

        <div class="button-container">
            <button type="submit">Submit</button>
        </div>

    </form>
</div>
</body>
</html>
<script>
    document.getElementById('resetPasswordForm').addEventListener('submit', function(event) {
        var password = document.getElementById('password').value;
        var confirmPassword = document.getElementById('confirmPassword').value;
        var passwordMismatchMessage = document.getElementById('passwordMismatchMessage');

        if (password !== confirmPassword) {
            passwordMismatchMessage.textContent = 'Error: Passwords do not match';
            event.preventDefault();
        } else {
            passwordMismatchMessage.textContent = '';
        }
    });
</script>
