<?php

namespace App\Controllers;

use App\Services\UserService;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../vendor/PHPMailer-master/src/PHPMailer.php';
require_once __DIR__ . '/../vendor/PHPMailer-master/src/Exception.php';
require_once __DIR__ . '/../vendor/PHPMailer-master/src/SMTP.php';

class ForgotPasswordController
{
    private UserService $forgotPasswordService;

    public function __construct()
    {
        $this->forgotPasswordService = new UserService();
    }

    public function resetPassword()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['email'])) {
            $email = $_POST['email'];
            $userExists = $this->forgotPasswordService->getUserByEmail($email);

            if ($userExists) {
                $token = bin2hex(random_bytes(32));
                $_SESSION['password_reset_token'] = $token;
                $_SESSION['email'] = $email;

                $reset_link = "http://localhost/ForgotPassword/setNewPassword?token=$token";
                $mailConfig = require_once __DIR__ . '/../config/mail.php';
                $this->sendResetPasswordEmail($email, $reset_link, $mailConfig);
            } else {
                require_once __DIR__ . '/../views/frontend/auth/reset-password-sent.php';
                exit();
            }
            require_once __DIR__ . '/../views/frontend/auth/reset-password-sent.php';
            exit();
        }
        require_once __DIR__ . '/../views/frontend/auth/reset-password.php';
    }

    private function sendResetPasswordEmail($email, $reset_link, $mailConfig): bool
    {
        $user = $this->forgotPasswordService->getUserByEmail($email);
        $name = $user['name'];

        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = $mailConfig['host'];
            $mail->SMTPAuth = $mailConfig['SMTPAuth'];
            $mail->Username = $mailConfig['username'];
            $mail->Password = $mailConfig['password'];
            $mail->SMTPSecure = $mailConfig['SMTPSecure'];
            $mail->Port = $mailConfig['port'];

            // Recipients
            $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = 'Password Reset Request';
            $mail->Body = "Dear $name,<br><br>Click the following link to reset your password: <a href='$reset_link'>$reset_link</a>";

            $mail->send();

            return true;
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            return false;
        }
    }

    public function setNewPassword()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_GET['token']) && isset($_SESSION['password_reset_token']) && isset($_SESSION['email']) && $_GET['token'] === $_SESSION['password_reset_token']) {
            $userService = new UserService();

            $user = [
                'email' => $_SESSION['email'],
                'password' => $_POST['password']
            ];
            $token = $_GET['token'];
            $hashedPassword = $userService->hashPassword($user['password']);
            $result = $userService->resetPassword($user['email'], $hashedPassword, $token);

            if ($result) {
                header("Location: /login/login");
                exit();
            }
        }
        require_once __DIR__ . '/../views/frontend/auth/set-new-password.php';

    }
}
