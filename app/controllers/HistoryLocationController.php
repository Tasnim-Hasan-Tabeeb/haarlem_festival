<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\View;
use App\Services\HistoryService;
use Exception;

class HistoryLocationController extends Controller
{
    private HistoryService $historyService;

    public function __construct()
    {
        $this->historyService = new HistoryService();
    }

    /**
     * Summary of index
     */
    public function index()
    {
        try {
            $locations = $this->historyService->getAllTourLocations();
            return View::make('backend.historylocations.index', compact('locations'));
        } catch (Exception $e) {
            return $this->handleException($e, '/historylocation');
        }
    }

    /**
     * Summary of create
     */
    public function create()
    {
        try {
           return View::make('backend.historylocations.create');
        } catch (Exception $e) {
           return $this->handleException($e, '/historylocation');
        }
    }

    /**
     * Summary of store
     */
    public function store()
    {
        try {
            $this->historyService->addLocation();
            return $this->success('Location added successfully', '/historylocation');
        } catch (Exception $e) {
           return $this->handleException($e, '/historylocation');
        }
    }

    /**
     * Summary of edit
     */
    public function edit()
    {
        try {
            $locationId = $_GET['id'];
            $location   = $this->historyService->getTourLocationById($locationId);
            return View::make('backend.historylocations.edit', compact('location'));
        } catch (Exception $e) {
            return $this->handleException($e, '/historylocation');
        }
    }

    /**
     * Summary of update
     * @throws Exception
     */
    public function update()
    {
        try{
            $this->historyService->updateLocation();
            return $this->success('Location updated successfully', '/historylocation');
        }catch (Exception $e) {
            return $this->handleException($e, '/historylocation');
        }
    }

    /**
     * Summary of delete
     */
    public function delete()
    {
        try {
            $locationId = $_GET['id'];
            $this->historyService->deleteLocation($locationId);
            return $this->success('Location deleted successfully', '/historylocation');
        } catch (Exception $e) {
           return $this->handleException($e, '/historylocation');
        }
    }
}
