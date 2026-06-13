<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\View;
use App\Models\Role;
use App\Services\AuthService;
use Exception;

class LoginController extends Controller
{
    private AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    /**
     * Summary of logout
     */
    public function logout()
    {
        try {
            $this->authService->logout();
            return $this->redirect('/');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage(), '/');
        }
    }

    /**
     * Summary of login
     * @throws Exception
     */
    public function login()
    {
        try {
            if (isset($_POST['login-button'])) {
                $user = $this->authService->authenticateUser();

                if(!$user){
                    throw new Exception('User not found');
                }
                $this->authService->setSession($user);
                $redirectUrl = $user['role'] == Role::Administrator ? '/home/dashboard' : '/';
                return $this->redirect($redirectUrl);
            }

        return View::make('frontend.auth.login');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage(), '/login/login');
        }
    }

    /**
     * Summary of signup
     */
    public function signup()
    {
        try {
             if (isset($_POST['signup-button'])) {
                if(!$this->authService->captchaVerification()) {
                    return $this->error('Captcha verification failed', '/login/signup');
                }

                $this->authService->registerUser();
                return $this->success('User registered successfully', '/login/login');
            }

            return View::make('frontend.auth.signup');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }
}
