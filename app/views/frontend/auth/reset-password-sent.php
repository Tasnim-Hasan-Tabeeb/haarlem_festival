<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Sent</title>

    <link rel="icon" type="image/x-icon" href="/images/fav.png">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <?php $emailSentCssVersion = filemtime(__DIR__ . '/../../../public/frontend/css/email-sent.css'); ?>
    <link rel="stylesheet" href="/frontend/css/email-sent.css?v=<?= $emailSentCssVersion ?>">
</head>

<body>

<div class="email-card">

    <!-- Animated Mail Icon -->
    <div class="mail-animation">
        <div class="circle"></div>
        <div class="icon">
            <i class="bi bi-envelope-check-fill"></i>
        </div>
    </div>

    <h1>Email Sent Successfully</h1>
    <p>
        If you're registered in our system, you will receive an email shortly.
    </p>

    <a href="/login/login" class="btn-back">
        Back to Login
    </a>

    <div class="subtext">
        Please check your inbox or spam folder.
    </div>

</div>

</body>
</html>
