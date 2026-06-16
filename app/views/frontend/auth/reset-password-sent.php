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

    <style>
        body {
            background: radial-gradient(circle at top, #f8fafc, #e2e8f0);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif;
        }

        .email-card {
            width: 100%;
            max-width: 420px;
            background: rgba(255,255,255,0.85);
            border: 1px solid rgba(0,0,0,0.06);
            border-radius: 18px;
            padding: 40px 30px;
            text-align: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.08);
            backdrop-filter: blur(10px);
        }

        /* Animated Mail Icon */
        .mail-animation {
            width: 90px;
            height: 90px;
            margin: 0 auto 20px;
            position: relative;
        }

        .mail-animation .circle {
            position: absolute;
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background: rgba(16,185,129,0.15);
            animation: pulse 1.8s infinite;
        }

        .mail-animation .icon {
            position: absolute;
            inset: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 38px;
            color: #10b981;
            animation: float 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0% { transform: scale(0.8); opacity: 0.7; }
            70% { transform: scale(1.4); opacity: 0; }
            100% { opacity: 0; }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-6px); }
        }

        h1 {
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        p {
            color: #6b7280;
            font-size: 14px;
            margin-bottom: 25px;
        }

        .btn-back {
            background: #111827;
            color: white;
            border-radius: 10px;
            padding: 10px 16px;
            text-decoration: none;
            display: inline-block;
            transition: 0.2s;
        }

        .btn-back:hover {
            background: #1f2937;
        }

        .subtext {
            margin-top: 15px;
            font-size: 12px;
            color: #9ca3af;
        }
    </style>
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