<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\View;
use App\Services\RestaurantService;
use App\Services\SessionService;
use Exception;

class SessionController extends Controller
{
    private SessionService $sessionService;
    private RestaurantService $restaurantService;

    public function __construct()
    {
        $this->sessionService    = new SessionService();
        $this->restaurantService = new RestaurantService();
    }

    /**
     * Summary of index
     */
    public function index()
    {
        try {
            $sessions = $this->sessionService->getAllSessions();
            return View::make('backend.sessions.index', compact('sessions'));
        } catch (Exception $e) {
           return $this->handleException($e, '/session');
        }
    }

    /**
     * Summary of create
     */
    public function create()
    {
        try {
            $restaurants = $this->restaurantService->getAllRestaurants();
            $events      = $this->sessionService->getAllEvents();
            return View::make('backend.sessions.create', compact('restaurants', 'events'));
        } catch (Exception $e) {
            return $this->handleException($e, '/session');
        }
    }

    /**
     * Summary of store
     */
    public function store()
    {
        try {
            $this->sessionService->createSession();
            return $this->success('Session added successfully!', '/session');
        } catch (Exception $e) {
            return $this->handleException($e, '/session');
        }
    }

   /**
    * Summary of edit
    */
   public function edit()
    {
        try {
            $id          = $_GET['id'];
            $session     = $this->sessionService->getSession((int) $id);
            $restaurants = $this->restaurantService->getAllRestaurants();
            $events      = $this->sessionService->getAllEvents();
            return View::make('backend.sessions.edit', compact('session', 'restaurants', 'events'));
        } catch (Exception $e) {
           return $this->handleException($e, '/session');
        }
    }

    /**
     * Summary of update
     */
    public function update()
    {
        try {
            $this->sessionService->updateSession();
            return $this->success('Session updated successfully!', '/session');
        } catch (Exception $e) {
            return $this->handleException($e, '/session');
        }
    }

    /**
     * Summary of delete
     */
    public function delete()
    {
        try {
            $id = $_GET['id'];
            $this->sessionService->deleteSession($id);
            return $this->success('Session deleted successfully!', '/session');
        } catch (Exception $e) {
            return $this->handleException($e, '/session');
        }
    }
}
