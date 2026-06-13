<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="icon" type="image/x-icon" href="/images/fav.png">

    <!-- Bootstrap (ONLY ONE) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/frontend/css/login.css" />

    <title>Login</title>
</head>

<body class="login-page">

<div class="login-wrapper">
    <div class="login-card">

        <h3 class="login-title">Welcome Back</h3>
        <p class="login-subtitle">Login to your account</p>

        <?php include __DIR__ . '/../inc/message.php'; ?>

        <form method="POST" autocomplete="off">

            <div class="form-group">
                <label>Username</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-person"></i>
                    </span>
                    <input placeholder="Username" type="text" class="form-control" name="username" required>
                </div>
            </div>

            <div class="form-group mt-3">
                <label>Password</label>
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-lock"></i>
                    </span>
                    <input placeholder="Password" type="password" class="form-control" name="password" required>
                </div>
            </div>

            <button type="submit" name="login-button" class="btn login-btn mt-4 w-100">
                Login
            </button>

            <div class="login-links mt-3">
                <a href="/ForgotPassword/resetPassword">Forgot Password?</a>
                <a href="/login/signup">Sign Up</a>
            </div>

        </form>
    </div>
</div>

<footer class="login-footer">
<p>&copy; <?= date('Y') ?> The Festival. All rights reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>