<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Signup</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="/frontend/css/signup.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">


    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>

<body class="signup-page">

<div class="signup-wrapper">
    <div class="signup-card">

        <h3 class="signup-title">Create Account</h3>
        <p class="signup-subtitle">Join with us today</p>

        <?php include __DIR__ . '/../inc/message.php'; ?>


        <form method="POST" enctype="multipart/form-data">

            <!-- Avatar Upload -->
            <div class="avatar-box">
                <div class="avatar-preview-wrapper">
                    <img src="" id="imagePreview" class="avatar-preview d-none">
                    <div id="avatarPlaceholder" class="avatar-placeholder">
                        <i class="bi bi-person"></i>
                    </div>
                </div>

                <label for="profile_picture" class="avatar-upload-btn">
                    <i class="bi bi-pencil"></i>
                </label>

                <input type="file" name="profile_picture" id="profile_picture"
                    accept=".png, .jpg, .jpeg .webp"
                    hidden>
            </div>

            <!-- Name -->
            <div class="form-group">
                <label>Name</label>
                <input required type="text" name="name" class="form-control" placeholder="Enter your full name">
            </div>

            <!-- Email -->
            <div class="form-group mt-3">
                <label>Email</label>
                <input required type="email" name="email" class="form-control" placeholder="Enter your email address">
            </div>

            <!-- Password -->
            <div class="form-group mt-3">
                <label>Password</label>
                <input required type="password" name="password" class="form-control" placeholder="Enter password">
            </div>

            <!-- Confirm Password -->
            <div class="form-group mt-3">
                <label>Confirm Password</label>
                <input required type="password" name="confirm_password" class="form-control" placeholder="Confirm your password">
            </div>

            <!-- Captcha -->
            <div class="mt-3">
                <div class="g-recaptcha" data-sitekey="6LeIxAcTAAAAAJcZVRqyHh71UMIEGNQ_MXjiZKhI"></div>
            </div>

            <!-- Button -->
            <button type="submit" name="signup-button" class="btn signup-btn w-100 mt-4">
                Register
            </button>

            <!-- Login Link -->
            <div class="signup-links">
                <p>Already have an account? <a href="/login/login">Login</a></p>
            </div>

        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



<?php $signupJsVersion = filemtime(__DIR__ . '/../../../public/frontend/js/signup.js'); ?>
<script src="/frontend/js/signup.js?v=<?= $signupJsVersion ?>"></script>

</body>
</html>
