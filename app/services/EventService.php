<?php

namespace App\Services;



use App\Models\Events;
use App\Repositories\EventRepository;

class EventService{
    private EventRepository $eventRepository ;

    public function __construct()
    {
        $this->eventRepository = new EventRepository();
    }

    public function getAll()
    {
        try {
            return $this->eventRepository->getAll();
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function getEventById(int $event_id)
    {
        try {
            return $this->eventRepository->getEventById($event_id);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function storeEvent(Events $event)
    {
        try {
            return $this->eventRepository->storeEvent($event);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function deleteEvent($event_id)
    {
        try {
            return $this->eventRepository->deleteEvent($event_id);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function updateEvent(Events $event, $event_id)
    {
        try {
            return $this->eventRepository->updateEvent($event, $event_id);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}
