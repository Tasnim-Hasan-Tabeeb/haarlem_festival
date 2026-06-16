<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\View;
use App\Models\SessionType;
use App\Services\ArtistService;
use App\Services\DanceService;
use App\Services\EventService;
use App\Services\VenueService;
use Exception;

class DanceManagementController extends Controller
{
    private DanceService $danceService;
    private VenueService $venueService;
    private ArtistService $artistService;

    private EventService $eventService;

    public function __construct()
    {
        $this->danceService  = new DanceService();
        $this->venueService  = new VenueService();
        $this->artistService = new ArtistService();
        $this->eventService  = new EventService();
    }

    /**
     * LIST ALL EVENTS
     */
    public function index()
    {
        try {
            $dancesManages = $this->danceService->getAllEvents();
            return View::make('backend.danceManagement.index', compact('dancesManages'));
        } catch (Exception $e) {
            return $this->handleException($e, '/dancemanagement');
        }
    }

    /**
     * SHOW CREATE FORM
     */
    public function create()
    {
        try {
            $artists      = $this->artistService->getAllArtists();
            $venues       = $this->venueService->getAllVenues();
            $sessionTypes = SessionType::getAll();
            $events       = $this->eventService->getDanceEvents();

            return View::make('backend.danceManagement.create', compact('artists', 'venues', 'sessionTypes', 'events'));
        } catch (Exception $e) {
            return $this->handleException($e, '/dancemanagement');
        }
    }

    /**
     * STORE NEW EVENT
     */
    public function store()
    {
        try {
            $this->danceService->storeDance();
            return $this->success('Event created successfully', '/dancemanagement');
        } catch (Exception $e) {
            return $this->handleException($e, '/dancemanagement');
        }
    }

    /**
     * SHOW EDIT FORM
     */
    public function edit()
    {
        try {
            $id                = $_GET['id'];
            $dance             = $this->danceService->getEventById($id);
            $artists           = $this->artistService->getAllArtists();
            $venues            = $this->venueService->getAllVenues();
            $sessionTypes      = SessionType::getAll();
            $events            = $this->eventService->getDanceEvents();
            $selectedArtistIds = $this->danceService->getArtistIdsByEventId($dance['music_event_id']);

            return View::make(
                'backend.danceManagement.edit',
                compact('dance', 'artists', 'venues', 'sessionTypes', 'selectedArtistIds', 'events')
            );
        } catch (Exception $e) {
            return $this->handleException($e, '/dancemanagement');
        }
    }

    /**
     * UPDATE EVENT
     */
   public function update()
   {
        try {
            $this->danceService->updateDance();
            return $this->success('Event updated successfully', '/dancemanagement');
        } catch (Exception $e) {
            return $this->handleException($e, '/dancemanagement');
        }
    }
    /**
     * DELETE EVENT
     */
    public function delete()
    {
        try {
            $id = $_GET['id'];
            $this->danceService->deleteDance($id);
            return $this->success('Event deleted successfully', '/dancemanagement');
        } catch (Exception $e) {
            return $this->handleException($e, '/dancemanagement');
        }
    }
}
