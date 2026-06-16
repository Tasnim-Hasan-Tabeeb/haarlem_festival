<?php

namespace App\Services;

use App\Helpers\Validator;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Traits\Fileable;
use Exception;

class UserService
{
    use Fileable;
    private UserRepository $userRepository;

    public function __construct()
    {
        $this->userRepository = new UserRepository();
    }

    /**
     * Summary of getAllUsers
     * @throws Exception
     * @return array
     */
    public function getAllUsers()
    {
        try {
            return $this->userRepository->getAllUsers();
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of storeUser
     * @param mixed $user
     * @throws Exception
     * @return bool
     */
    public function storeUser(?User $user = null)
    {
        try {
            if ($user) {
                return $this->userRepository->storeUser($user);
            }

            $rules = [
                'name'            => 'required|string|min:2|max:100',
                'email'           => 'required|email|unique:users',
                'password'        => 'required|string|min:6|max:255',
                'role'            => 'required',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ];

            $email = $_POST['email'];

            $existingUser = $this->getUserByEmail($email);

            if($existingUser) {
                throw new Exception('Email already exists');
            }

            Validator::validate($_POST, $rules);

            $imageUrl = '/images/default.webp';

            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
                $imageUrl = $this->uploadImage($_FILES['profile_picture']);
            }

            $user = new User();
            $user->setName($_POST['name']);
            $user->setEmail($_POST['email']);
            $user->setPassword(password_hash($_POST['password'], PASSWORD_DEFAULT));
            $user->setRole($_POST['role']);
            $user->setProfilePicture($imageUrl);

            return $this->userRepository->storeUser($user);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of getUserById
     * @param mixed $userId
     * @throws Exception
     */
    public function getUserById($userId)
    {
        try {
            return $this->userRepository->getUserById($userId);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of getUserByEmail
     * @param mixed $email
     * @throws Exception
     */
    public function getUserByEmail($email)
    {
        try {
            return $this->userRepository->getUserByEmail($email);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of updateUser
     * @throws Exception
     * @return bool
     */
    public function updateUser()
    {
        try {
             $rules = [
                'user_id'         => 'required|integer',
                'name'            => 'required|string|min:2|max:100',
                'email'           => 'required|email|unique:users',
                'role'            => 'required',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ];

            Validator::validate($_POST, $rules);

            $user = $this->getUserById($_POST['user_id']);

            $profileImg = isset($user['profile_picture']) ? $user['profile_picture'] : '/images/default.webp';

            $email = $_POST['email'];

            $existingUser = $this->getUserByEmail($email);

            if($existingUser && $existingUser['user_id'] != $_POST['user_id']) {
                throw new Exception('Email already exists');
            }

            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
                $this->unlinkImage($profileImg);
                $file       = $_FILES['profile_picture'];
                $profileImg = $this->uploadImage($file);
            }

            $userData = [
                'user_id'         => $_POST['user_id'],
                'name'            => $_POST['name'],
                'email'           => $_POST['email'],
                'role'            => $_POST['role'],
                'profile_picture' => $profileImg,
            ];

            return $this->userRepository->updateUser($userData);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of deleteUser
     * @param mixed $userId
     * @throws Exception
     * @return bool
     */
    public function deleteUser($userId)
    {
        try {
            $this->unlinkImage($this->getUserById($userId)['profile_picture']);
            return $this->userRepository->deleteUser($userId);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of updateProfile
     * @throws Exception
     * @return bool
     */
    public function updateProfile()
    {
        try {
            Validator::validate($_POST, [
                'name'            => 'required|max:255',
                'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ]);

            $user = $_SESSION['user'];

            $profileImg = $user['profile_picture'];

            if (isset($_FILES['profile_picture']) && $_FILES['profile_picture']['error'] === UPLOAD_ERR_OK) {
                $this->unlinkImage($profileImg);
                $file       = $_FILES['profile_picture'];
                $profileImg = $this->uploadImage($file);
            }

            $userData = [
                'user_id'         => $user['user_id'],
                'name'            => $_POST['name'],
                'profile_picture' => $profileImg,
            ];
            return $this->userRepository->updateProfile($userData);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    public  function updatePassword()
    {
        try {
            $rules = [
                'new_password' => 'required|string|min:6|confirmed',
            ];
            Validator::validate($_POST, $rules);
            $user     = $_SESSION['user'];
            $password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
            return $this->userRepository->updatePassword($user['user_id'], $password);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of isValidEmail
     * @param mixed $email
     * @return bool
     */
    public function isValidEmail($email): bool
    {
        return filter_var($email, FILTER_VALIDATE_EMAIL);
    }
 }
