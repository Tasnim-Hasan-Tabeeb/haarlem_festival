<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\Validator;
use App\Helpers\View;
use App\Services\AuthService;
use Exception;

class ForgotPasswordController extends Controller
{
    private AuthService $forgotPasswordService;

    public function __construct()
    {
        $this->forgotPasswordService = new AuthService();
    }

    /**
     * Summary of resetPassword
     */
    public function resetPassword()
    {
      try {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            Validator::validate($_POST, ['email' => 'required|email']);

            $email      = $_POST['email'];
            $userExists = $this->forgotPasswordService->getUserByEmail($email);

            if(!$userExists) {
              return $this->error('User does not exist', '/ForgotPassword/resetPassword');
            }

            $token                            = bin2hex(random_bytes(32));
            $_SESSION['password_reset_token'] = $token;
            $_SESSION['email']                = $email;

            $reset_link = "http://localhost/ForgotPassword/setNewPassword?token=$token";
            $mailConfig = require_once __DIR__ . '/../config/mail.php';
            $this->forgotPasswordService->sendResetPasswordEmail($email, $reset_link, $mailConfig);

            return View::make('frontend.auth.reset-password-sent');
        }

        return View::make('frontend.auth.reset-password');
      } catch (Exception $ex) {
        return $this->error($ex->getMessage(), '/login/login');
      }
    }

    /**
     * Summary of setNewPassword
     */
    public function setNewPassword()
    {
        try {
             if ($this->forgotPasswordService->isPasswordUpdateRequest()) {
                $user = [
                    'email'    => $_SESSION['email'],
                    'password' => $_POST['password']
                ];

                $token          = $_GET['token'];
                $hashedPassword = $this->forgotPasswordService->hashPassword($user['password']);
                $response       = $this->forgotPasswordService->resetPassword($user['email'], $hashedPassword, $token);

                if(!$response) {
                    return $this->error('Password reset failed', '/login/login');
                }

                return $this->success('Password reset successfully', '/login/login');
            }
            return View::make('frontend.auth.set-new-password');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage(), '/login/login');
        }
    }
}
