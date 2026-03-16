<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Exception;
use PDOException;

require_once __DIR__ . '/../utils/const.php';

class UserService
{
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    public function authenticateUser($username, $password)
    {
        $user = $this->userRepository->authenticateUser($username, $password);
        if ($user) {
            return $user;
        }
        return null;
    }

    public function hashPassword($password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }

    /**
     * @throws Exception
     */
    public function handleUserImage($image)
    {
        try {
            $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
            $newImageName = uniqid() . '.' . $ext;
            $upload_dir = __DIR__ . '/../public/images/';
            if (!move_uploaded_file($image['tmp_name'], $upload_dir . $newImageName)) {
                throw new Exception("Failed to move uploaded file.");
            }
            return $newImageName;

        } catch (Exception $exception) {
            echo $exception->getMessage();
        }
    }

    public function registerUser($newUser): bool
    {
        $plainPassword = $newUser['password'];
        $newUser['password'] = $this->hashPassword($plainPassword);
        $image = $newUser['profile_picture'];
        if (!empty($image['name'])) {
            $newUser['profile_picture'] = $this->handleUserImage($image);
        } else {
            $newUser['profile_picture'] = DEFAULT_PROFILE_PICTURE;
        }
        return $this->userRepository->registerUser($newUser);
    }

    public function checkIfUserExists($email)
    {
        return $this->userRepository->checkUserExistenceByEmail($email);
    }

    public function captchaVerification(&$systemMessage)
    {
        $secret = "6LeIxAcTAAAAAGG-vFI1TnRWxMZNFuojJ4WifJWe";
        $response = $_POST['g-recaptcha-response'];
        $remoteip = $_SERVER['REMOTE_ADDR'];
        $url = "https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip";
        $data = file_get_contents($url);
        $row = json_decode($data);
        if ($row->success == "true") {
            return true;
        } else {
            $systemMessage = "you are a robot";
            return false;
        }
    }

    public function getAllUsers()
    {
        try {
            return $this->userRepository->getAllUsers();
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function storeUser(User $user)
    {
        try {
            return $this->userRepository->storeUser($user);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getUserById($userId)
    {
        try {
            return $this->userRepository->getUserById($userId);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getUserByEmail($email)
    {
        try {
            return $this->userRepository->getUserByEmail($email);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function updateUser($user)
    {
        try {
            return $this->userRepository->updateUser($user);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function deleteUser($userId)
    {
        try {
            return $this->userRepository->deleteUser($userId);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }


    public function resetPassword($email, $password, $token)

    {
        if ($token !== $_SESSION['password_reset_token']) {
            throw new Exception("Invalid token.");
        }
        try {
            $result = $this->userRepository->resetPassword($email, $password); // Remove $token parameter
            unset($_SESSION['password_reset_token']);
            unset($_SESSION['email']);

            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }


    public function isValidEmail($email): bool
    {
//        var_dump($email);
//        die();
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
    public function isStrongPassword($password)
    {
        $pattern = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,}$/';
        return preg_match($pattern, $password);
    }

}
