<?php

namespace App\Controllers;

use App\Services\HistoryService;
use Exception;

class HistoryTourController
{
    private HistoryService $historyService;
    public function __construct()
    {
        $this->historyService = new HistoryService();
    }
    public function index()
    {
        try{
            $tours = $this->historyService->getAllTours();
            require_once __DIR__ . '/../views/backend/historytours/index.php';
        }catch (Exception $e) {
            header('Location: /error?message=' . urlencode($e->getMessage()));
            exit();
        }
    }
    public function edit()
    {
        try {
            $id = $_GET['id'];

            $tour      = $this->historyService->getTourById($id);
            $timeslots = $this->historyService->getAllTimeSlots();
            $languages = $this->historyService->getAllLanguages();

            require_once __DIR__ . '/../views/backend/historytours/edit.php';
        } catch (Exception $e) {
            header('Location: /error?message=' . urlencode($e->getMessage()));
            exit();
        }
    }
    public function create()
    {
        try {
            $timeslots = $this->historyService->getAllTimeSlots();
            $languages = $this->historyService->getAllLanguages();

            require_once __DIR__ . '/../views/backend/historytours/create.php';
        } catch (Exception $e) {
            header('Location: /error?message=' . urlencode($e->getMessage()));
            exit();
        }
    }

    public function add()
    {
        try {
            $this->historyService->addTour(
                $_POST['timetable_id'],
                $_POST['language_id'],
                $_POST['available_guides']
            );

            $_SESSION['flash_message'] = 'Tour created!';
            header('Location: /historytour');
            exit();
        } catch (Exception $e) {
            header('Location: /error?message=' . urlencode($e->getMessage()));
            exit();
        }
    }

    public function update()
    {
        try {
            $this->historyService->updateTour(
                $_POST['tour_id'],
                $_POST['timetable_id'],
                $_POST['language_id'],
                $_POST['available_guides']
            );

            $_SESSION['flash_message'] = 'Tour updated!';
            header('Location: /historytour');
            exit();
        } catch (Exception $e) {
            header('Location: /error?message=' . urlencode($e->getMessage()));
            exit();
        }
    }

    public function delete()
    {
        try {
            $this->historyService->deleteTour($_GET['id']);

            $_SESSION['flash_message'] = 'Tour deleted!';
            header('Location: /historytour');
            exit();
        } catch (Exception $e) {
            header('Location: /error?message=' . urlencode($e->getMessage()));
            exit();
        }
    }
}
