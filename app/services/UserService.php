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
}
