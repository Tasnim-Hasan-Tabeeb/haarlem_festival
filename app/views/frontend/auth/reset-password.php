<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="icon" type="image/x-icon" href="/images/fav.png">
    <style>
        <?php include __DIR__ . '/../../../public/frontend/css/style.css'; ?>
    </style>
</head>
<body class="reset-pass">
<img src="/images/logo.png" alt="Logo" class="logo">
<div class="container-email">
    <h1>Reset Password</h1>
    <form action="#" method="post">
        <input type="email" name="email" placeholder="Enter your email address" required>
        <input type="submit" value="Send Email">
        <a href="/login/login" class="back-to-login-pass">Back to Login Page</a>

    </form>
</div>
</body>
</html>
