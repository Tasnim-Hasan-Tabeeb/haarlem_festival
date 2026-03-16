<?php

namespace App\Controllers;

use App\Models\Role;

use App\Models\User;
use App\services\UserService;
use Exception;

require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../services/UserService.php';

class LoginController
{
    private UserService $loginService;

    public function __construct()
    {
        $this->loginService = new UserService();
    }

    public function logout()
    {
        session_unset();
        session_destroy();
        header("location: /");
        exit();
    }

    public function login()
    {
        if (isset($_POST['login-button']) && isset($_POST['username']) && isset($_POST['password'])) {
            $username = htmlspecialchars($_POST['username']);
            $password = htmlspecialchars($_POST['password']);
            $user = $this->loginService->authenticateUser($username, $password);
            if ($user) {
                $_SESSION['user'] = $user;
                $_SESSION['username'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                $_SESSION['profile_picture'] = $user['profile_picture'];
                if ($_SESSION['role'] == "Admin") {
                    header("location: /home/dashboard");
                } elseif ($_SESSION['role'] == "Employee") {
                    header("location: /ScanTicket/scanTicket");
                }else {
                    header("location: /");
                }
                exit();
            } else {
                $_SESSION['flash_message'] = "Invalid username or password";
                header("location: /login/login");
                exit();
            }
        } else {
            require_once __DIR__ . '/../views/frontend/auth/login.php';
        }
    }

    private function createNewUser(): void
    {
        $name = htmlspecialchars($_POST['name']);
        $email = htmlspecialchars($_POST['email']);
        $password = htmlspecialchars($_POST['password']);
        $role = Role::Customer();
        $picture = $_FILES['profile_picture'];

        if (!empty($name) && !empty($email) && !empty($password)) {
            $newUser = array(
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'profile_picture' => $picture,
                'role' => $role
            );
            $success = $this->loginService->registerUser($newUser);
            if ($success) {
                $_SESSION['username'] = $name;
                $_SESSION['role'] = $role;
                $_SESSION['profile_picture'] = $picture;
                header("location: /");
                exit();
            } else {
                $_SESSION['flash_message'] = "Failed to create user";
                header("Location: /login/signup");
                exit();
            }
        }
        require __DIR__ . '/../views/auth/signup.php';
    }

    private function registerUser(): void
    {
        if (!$this->loginService->isValidEmail(htmlspecialchars($_POST['email']))) {
            $_SESSION['flash_message'] = "Invalid email";
            header("Location: /login/signup");
            exit();
        } else if ($this->loginService->checkIfUserExists(htmlspecialchars($_POST['email']))) {
            $_SESSION['flash_message'] = "User already exists";
            header("Location: /login/signup");
            exit();
        } elseif (!$this->loginService->isStrongPassword(htmlspecialchars($_POST['password']))) {
            $_SESSION['flash_message'] = "Password is weak. It should contain at least 8 characters, 1 uppercase letter, 1 lowercase letter, 1 number and 1 special character.";
            header("Location: /login/signup");
            exit();
        } elseif ($_POST['password'] != $_POST['confirm_password']) {
            $_SESSION['flash_message'] = "Passwords do not match";
            header("Location: /login/signup");
            exit();
        } else {
            $this->createNewUser();
        }
    }

    public function signup()
    {
        $errormessage = "";
        if (isset($_POST['signup-button'])) {
            if (empty($_POST['name'])) {
                $_SESSION['flash_message'] = "Name is required";
            } else if (empty($_POST['email'])) {
                $_SESSION['flash_message'] = "Email is required";
            } else if (empty($_POST['password'])) {
                $_SESSION['flash_message'] = "Password is required";
            } else {
                if ($this->loginService->captchaVerification($errormessage)) {
                    $this->registerUser();
                } else {
                    $errormessage = "Captcha verification failed";
                }
            }
            header("Location: /login/signup");
            exit();
        } else {
            require_once __DIR__ . '/../views/frontend/auth/signup.php';
        }
    }
}
