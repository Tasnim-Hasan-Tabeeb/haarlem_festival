<?php

namespace App\Services;

use App\Helpers\Validator;
use App\Models\Events;
use App\Repositories\EventRepository;
use App\Traits\Fileable;
use Exception;

class EventService
{
    use Fileable;
    private EventRepository $eventRepository ;

    public function __construct()
    {
        $this->eventRepository = new EventRepository();
    }

    public function getAll()
    {
        return $this->eventRepository->getAll();
    }

    public function getDanceEvents(){
        return $this->eventRepository->getDanceEvents();
    }

    public function getEventById(int $event_id)
    {
      return $this->eventRepository->getEventById($event_id);
    }

    /**
     * Summary of storeEvent
     * @throws Exception
     * @return bool
     */
    public function storeEvent()
    {
        $rules = [
            'event_type'            => 'required|string',
            'title'                 => 'required|string',
            'description'           => 'required|string',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date',
            'primary_theme_color'   => 'required|string',
            'secondary_theme_color' => 'required|string',
            'status'                => 'required|integer',
            'image_url'             => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        Validator::validate($_POST, $rules);

        $imageUrl = '/images/default.webp';

        if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
            $file     = $_FILES['image_url'];
            $imageUrl = $this->uploadImage($file);
        }
        $event = new Events(
            null,
            $_POST['event_type']            ?? '',
            $_POST['title']                 ?? '',
            $imageUrl                       ?? '',
            $_POST['description']           ?? '',
            $_POST['status']                ?? 1,
            $_POST['start_date']            ?? '',
            $_POST['end_date']              ?? '',
            $_POST['primary_theme_color']   ?? '',
            $_POST['secondary_theme_color'] ?? ''
        );
        return $this->eventRepository->storeEvent($event);
    }

    /**
     * Summary of deleteEvent
     * @param mixed $eventId
     * @throws Exception
     * @return bool
     */
    public function deleteEvent($eventId)
    {
        $this->unlinkImage($this->getEventById($eventId)['image_url']);
        return $this->eventRepository->deleteEvent($eventId);
    }

    /**
     * Summary of updateEvent
     * @throws Exception
     * @return bool
     */
    public function updateEvent()
    {
        $rules = [
            'event_id'              => 'required|numeric',
            'event_type'            => 'required|string',
            'title'                 => 'required|string',
            'description'           => 'required|string',
            'start_date'            => 'required|date',
            'end_date'              => 'required|date',
            'primary_theme_color'   => 'required|string',
            'secondary_theme_color' => 'required|string',
            'status'                => 'required|numeric|min:0|max:1',
            'image_url'             => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        Validator::validate($_POST, $rules);

        $eventId = $_POST['event_id'];

        $event    = $this->getEventById($eventId);
        $imageUrl = $event['image_url'];

        if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
            $this->unlinkImage($imageUrl);
            $file     = $_FILES['image_url'];
            $imageUrl = $this->uploadImage($file);
        }

        $event = new Events(
            (int) $_POST['event_id'],
            $_POST['event_type']            ?? '',
            $_POST['title']                 ?? '',
            $imageUrl                       ?? '',
            $_POST['description']           ?? '',
            $_POST['status']                ?? 1,
            $_POST['start_date']            ?? '',
            $_POST['end_date']              ?? '',
            $_POST['primary_theme_color']   ?? '',
            $_POST['secondary_theme_color'] ?? ''
        );

        return $this->eventRepository->updateEvent($event, $eventId);
    }
}
