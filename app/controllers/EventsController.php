<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\View;
use App\Models\EventTypes;
use App\Services\EventService;
use Exception;

class EventsController extends Controller
{
    private EventService $eventService;

    public function __construct()
    {
        $this->eventService = new EventService();
    }

    /**
     * Summary of index
     */
    public function index()
    {
        try {
            $events = $this->eventService->getAll();
            return View::make('backend.events.index', compact('events'));
        } catch (Exception $e) {
            return $this->handleException($e, '/events');
        }
    }

    /**
     * Summary of create
     */
    public function create()
    {
        try {
            $eventtypes = EventTypes::getEnumValues();
            return View::make('backend.events.create', compact('eventtypes'));
        } catch (Exception $e) {
            return $this->handleException($e, '/events');
        }
    }

    /**
     * Summary of store
     */
    public function store()
    {
        try {
            $this->eventService->storeEvent();
            return $this->success('Event created successfully!', '/events');
        } catch (Exception $e) {
            return $this->handleException($e, '/events');
        }
    }

    /**
     * Summary of edit
     */
    public function edit()
    {
        try {
            $event_id   = $_GET['id'];
            $eventtypes = EventTypes::getEnumValues();
            $event      = $this->eventService->getEventById($event_id);
            return View::make('backend.events.edit', compact('eventtypes', 'event'));
        } catch (Exception $e) {
            return $this->handleException($e, '/events');
        }
    }

    /**
     * Summary of update
     */
    public function update()
    {
        try {
            $this->eventService->updateEvent();
            return $this->success('Event updated successfully!', '/events');
        } catch (Exception $e) {
            return $this->handleException($e, '/events');
        }
    }

    /**
     * Summary of delete
     */
    public function delete()
    {
        $eventId = $_GET['id'];

        try {
           $this->eventService->deleteEvent($eventId);
           return $this->success('Event deleted successfully!', '/events');
        } catch (Exception $e) {
            return $this->handleException($e, '/events');
        }
    }
}
