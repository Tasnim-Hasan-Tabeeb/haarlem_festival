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
       return $this->userRepository->getAllUsers();
    }

    /**
     * Summary of storeUser
     * @param mixed $user
     * @throws Exception
     * @return bool
     */
    public function storeUser(?User $user = null)
    {
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
    }

    /**
     * Summary of getUserById
     * @param mixed $userId
     * @throws Exception
     */
    public function getUserById($userId)
    {
        return $this->userRepository->getUserById($userId);
    }

    /**
     * Summary of getUserByEmail
     * @param mixed $email
     * @throws Exception
     */
    public function getUserByEmail($email)
    {
        return $this->userRepository->getUserByEmail($email);
    }

    /**
     * Summary of updateUser
     * @throws Exception
     * @return bool
     */
    public function updateUser()
    {
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
    }

    /**
     * Summary of deleteUser
     * @param mixed $userId
     * @throws Exception
     * @return bool
     */
    public function deleteUser($userId)
    {
        $this->unlinkImage($this->getUserById($userId)['profile_picture']);
        return $this->userRepository->deleteUser($userId);
    }

    /**
     * Summary of updateProfile
     * @throws Exception
     * @return bool
     */
    public function updateProfile()
    {
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
    }

    public  function updatePassword()
    {
        $rules = [
            'new_password' => 'required|string|min:6|confirmed',
        ];
        Validator::validate($_POST, $rules);
        $user     = $_SESSION['user'];
        $password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);
        return $this->userRepository->updatePassword($user['user_id'], $password);
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
