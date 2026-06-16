<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\View;
use App\Services\HistoryService;
use Exception;

class HistoryTourController extends Controller
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
        try{
            $tours = $this->historyService->getAllTours();
            return View::make('backend.historytours.index', compact('tours'));
        }catch (Exception $e) {
            return $this->handleException($e, '/historytour');
        }
    }

    /**
     * Summary of create
     */
    public function create()
    {
        try {
            $timeslots = $this->historyService->getAllTimeSlots();
            $languages = $this->historyService->getAllLanguages();
            return View::make('backend.historytours.create', compact('timeslots', 'languages'));
        } catch (Exception $e) {
            return $this->handleException($e, '/historytour');
        }
    }

    /**
     * Summary of store
     */
    public function store()
    {
        try {
            $this->historyService->addTour();
            return $this->success('Tour created successfully!', '/historytour');
        } catch (Exception $e) {
           return $this->handleException($e, '/historytour');
        }
    }

    /**
     * Summary of edit
     */
    public function edit()
    {
        try {
            $id = $_GET['id'];

            $tour      = $this->historyService->getTourById($id);
            $timeslots = $this->historyService->getAllTimeSlots();
            $languages = $this->historyService->getAllLanguages();

            return View::make('backend.historytours.edit', compact('tour', 'timeslots', 'languages'));
        } catch (Exception $e) {
          return $this->handleException($e, '/historytour');
        }
    }

    /**
     * Summary of update
     */
    public function update()
    {
        try {
           $this->historyService->updateTour();
           return $this->success('Tour updated successfully!', '/historytour');
        } catch (Exception $e) {
            return $this->handleException($e, '/historytour');
        }
    }

    /**
     * Summary of delete
     */
    public function delete()
    {
        try {
            $this->historyService->deleteTour($_GET['id']);
            return $this->success('Tour deleted successfully!', '/historytour');
        } catch (Exception $e) {
            return $this->handleException($e, '/historytour');
        }
    }
}
