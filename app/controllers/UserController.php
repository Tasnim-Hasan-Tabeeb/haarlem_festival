<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\View;
use App\Models\Role;
use App\services\UserService;
use Exception;

class UserController extends Controller
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
           $users = $this->userService->getAllUsers();
           return View::make('backend.users.index', compact('users'));
        } catch (Exception $e) {
            return $this->handleException($e, '/user');
        }
    }

    /**
     * Summary of create
     */
    public function create()
    {
        try {
           $roles = Role::getEnumValues();
           return View::make('backend.users.create', compact('roles'));
        } catch (Exception $e) {
            return $this->handleException($e, '/user');
        }
    }

    /**
     * Summary of store
     */
    public function store()
    {
        try {
            $this->userService->storeUser();
            return $this->success('User created successfully!', '/user');
        } catch (Exception $e) {
            return $this->handleException($e, '/user');
        }
    }

    /**
     * Summary of edit
     */
    public function edit()
    {
        try {
            $userId = $_GET['id'];
            $user   = $this->userService->getUserById($userId);
            return View::make('backend.users.edit', compact('user'));
        } catch (Exception $e) {
            return $this->handleException($e, '/user');
        }
    }

    /**
     * Summary of update
     * @throws Exception
     */
    public function update()
    {
        try {
            $this->userService->updateUser();
            return $this->success('User updated successfully!', '/user');
        } catch (Exception $e) {
            return $this->handleException($e, '/user');
        }
    }

    /**
     * Summary of delete
     */
    public function delete()
    {
        try {
            $userId = $_GET['id'];
            $this->userService->deleteUser($userId);
            return $this->success('User deleted successfully!', '/user');
        } catch (Exception $ex) {
           return $this->handleException($ex, '/user');
        }
    }
}
