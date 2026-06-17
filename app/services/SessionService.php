<?php

namespace App\Services;

use App\Helpers\Validator;
use App\Models\Session;
use App\Repositories\SessionRepository;
use Exception;

class SessionService
{
    private SessionRepository $sessionRepository;

    public function __construct()
    {
        $this->sessionRepository = new SessionRepository();
    }

    public function getAllSessions()
    {
        return $this->sessionRepository->getAllSessions();
    }

    /**
     * Summary of getSessionsByRestaurantId
     * @param mixed $restaurantId
     * @throws Exception
     * @return array
     */
    public function getSessionsByRestaurantId($restaurantId)
    {
        return $this->sessionRepository->getSessionsByRestaurantId($restaurantId);
    }

    public function getAllEvents()
    {
        return $this->sessionRepository->getAllEvents();
    }

    /**
     * Summary of createSession
     * @throws Exception
     * @return bool
     */
    public function createSession()
    {
        $rules = [
            'restaurant_id'    => 'required|numeric',
            'event_id'         => 'required|numeric',
            'start_time'       => 'required',
            'duration'         => 'required|numeric|min:0.1|max:10000',
            'sessions_per_day' => 'required|numeric|min:1|max:10000',
        ];

        Validator::validate($_POST, $rules);

        $restaurantId   = $_POST['restaurant_id'];
        $eventId        = $_POST['event_id'];
        $startTime      = $_POST['start_time'];
        $duration       = $_POST['duration'];
        $sessionsPerDay = $_POST['sessions_per_day'];

        $session = new Session($restaurantId, $eventId, $startTime, $duration, $sessionsPerDay);
        return $this->sessionRepository->createSession($session);
    }

    /**
     * Summary of getSession
     * @param mixed $sessionId
     * @throws Exception
     */
    public function getSession($sessionId)
    {
      return $this->sessionRepository->getSession($sessionId);
    }

    /**
     * Summary of updateSession
     * @throws Exception
     * @return bool
     */
    public function updateSession()
    {
        $rules = [
            'session_id'       => 'required|numeric',
            'restaurant_id'    => 'required|numeric',
            'event_id'         => 'required|numeric',
            'start_time'       => 'required',
            'duration'         => 'required|numeric|min:0.1|max:10000',
            'sessions_per_day' => 'required|numeric|min:1|max:10000',
        ];

        Validator::validate($_POST, $rules);
        $sessionId      = $_POST['session_id'];
        $restaurantId   = $_POST['restaurant_id'];
        $eventId        = $_POST['event_id'];
        $startTime      = $_POST['start_time'];
        $duration       = $_POST['duration'];
        $sessionsPerDay = $_POST['sessions_per_day'];
        $session        = new Session($restaurantId, $eventId, $startTime, $duration, $sessionsPerDay);
        $session->setSessionId($sessionId);
        return $this->sessionRepository->updateSession($session);
    }

    /**
     * Summary of deleteSession
     * @param mixed $sessionId
     * @throws Exception
     * @return bool
     */
    public function deleteSession($sessionId)
    {
       return $this->sessionRepository->deleteSession($sessionId);
    }
}
