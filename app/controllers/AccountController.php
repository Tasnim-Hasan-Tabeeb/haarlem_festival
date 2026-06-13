<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\View;
use App\Services\UserService;
use Exception;

class AccountController extends Controller
{
    private UserService $userService;

    public function __construct()
    {
        $this->userService = new UserService();
    }

    /**
     * Summary of index
     */
    public function index()
    {
        try {
            $title = 'Profile';
            return View::make('frontend.account.profile', compact('title'));
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Summary of create
     */
    public function updateProfile()
    {
        try {
            $this->userService->updateProfile();
            $user             = $this->userService->getUserById($_SESSION['user']['user_id']);
            $_SESSION['user'] = $user;
            return $this->success('Profile updated successfully!', '/account');
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    /**
     * Summary of store
     * @throws Exception
     */
    public function updatePassword()
    {
        try {
            $this->userService->updatePassword();
            return $this->success('Password updated successfully!', '/account');
        } catch (Exception $e) {
         return $this->handleException($e);
        }
    }
 }
