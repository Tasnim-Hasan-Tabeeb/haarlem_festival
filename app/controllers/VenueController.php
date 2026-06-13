<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\View;
use App\Services\VenueService;
use Exception;

class VenueController extends Controller
{
    private VenueService $venueService;

    public function __construct()
    {
        $this->venueService = new VenueService();
    }

    /**
     * Summary of index
     */
    public function index()
    {
        try {
            $venues = $this->venueService->getAllVenues();
            return View::make('backend.venues.index', compact('venues'));
        } catch (Exception $e) {
            return $this->handleException($e, '/venue');
        }
    }

    /**
     * Summary of create
     */
    public function create()
    {
        try {
            return View::make('backend.venues.create');
        } catch (Exception $e) {
            return $this->handleException($e, '/venue');
        }
    }

    /**
     * Summary of store
     */
    public function store()
    {
        try {
            $this->venueService->storeVenue();
            return $this->success('Venue created successfully!', '/venue');
        } catch (Exception $e) {
            return $this->handleException($e, '/venue');
        }
    }

    /**
     * Summary of edit
     */
    public function edit()
    {
        try {
            $venueId = $_GET['id'];
            $venue   = $this->venueService->getVenuesById($venueId);
            return View::make('backend.venues.edit', compact('venue'));
        } catch (Exception $e) {
            return $this->handleException($e, '/venue');
        }
    }

    /**
     * Summary of update
     */
    public function update()
    {
        try {
            $this->venueService->updateVenue();
            return $this->success('Venue updated successfully!', '/venue');
        } catch (Exception $e) {
            return $this->handleException($e, '/venue');
        }
    }

    /**
     * Summary of delete
     */
    public function delete()
    {
        $venueId = $_GET['id'];

        try {
            $this->venueService->deleteVenue($venueId);
            return $this->success('Venue deleted successfully!', '/venue');
        } catch (Exception $e) {
            return $this->handleException($e, '/venue');
        }
    }
}
