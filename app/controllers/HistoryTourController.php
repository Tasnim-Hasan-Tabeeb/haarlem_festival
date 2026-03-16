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
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }
    public function edit()
    {
        require_once __DIR__ . '/../views/backend/historytours/edit.php';
    }
    public function create()
    {
        require_once __DIR__ . '/../views/backend/historytours/create.php';
    }
}