<?php

namespace App\Models;

class Session
{
    private $session_id;
    private $restaurant_id;
    private $start_time;
    private $duration;
    private $sessions_per_day;

    public function __construct($restaurant_id, $start_time, $duration, $sessions_per_day)
    {
        $this->restaurant_id = $restaurant_id;
        $this->start_time = $start_time;
        $this->duration = $duration;
        $this->sessions_per_day = $sessions_per_day;
    }

    public function getSessionId()
    {
        return $this->session_id;
    }

    public function setSessionId($session_id)
    {
        $this->session_id = $session_id;
    }

    public function getRestaurantId()
    {
        return $this->restaurant_id;
    }

    public function getStartTime()
    {
        return $this->start_time;
    }

    public function getDuration()
    {
        return $this->duration;
    }

    public function getSessionsPerDay()
    {
        return $this->sessions_per_day;
    }

    public function toArray()
    {
        return [
            'session_id' => $this->session_id,
            'restaurant_id' => $this->restaurant_id,
            'start_time' => $this->start_time,
            'duration' => $this->duration,
            'sessions_per_day' => $this->sessions_per_day,
        ];
    }
}