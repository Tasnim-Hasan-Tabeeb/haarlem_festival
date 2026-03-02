<?php

namespace App\Services;

use App\Models\Session;
use App\Repositories\SessionRepository;
use Exception;

class SessionService
{
    private $sessionRepository;

    public function __construct()
    {
        $this->sessionRepository = new SessionRepository();
    }

    public function getAllSessions()
    {
        try {
            return $this->sessionRepository->getAllSessions();
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getSessionsByRestaurantId($restaurantId)
    {
        try {
            return $this->sessionRepository->getSessionsByRestaurantId($restaurantId);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    
    public function getAllEvents()
    {
        try {
            return $this->sessionRepository->getAllEvents();
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function createSession($restaurantId, $startTime, $duration, $sessionsPerDay)
    {
        try {
            $session = new Session($restaurantId, $startTime, $duration, $sessionsPerDay);
            return $this->sessionRepository->createSession($session);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getSession($sessionId)
    {
        try {
            return $this->sessionRepository->getSession($sessionId);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function updateSession($sessionId, $restaurantId, $startTime, $duration, $sessionsPerDay)
    {
        try {
            $session = new Session($restaurantId, $startTime, $duration, $sessionsPerDay);
            $session->setSessionId($sessionId);
            return $this->sessionRepository->updateSession($session);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function deleteSession($sessionId)
    {
        try {
            return $this->sessionRepository->deleteSession($sessionId);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}