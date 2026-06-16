<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\View;
use App\Services\HistoryService;
use Exception;

class HistoryInformationController extends Controller
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
            $contents = $this->historyService->getAllContent();
            return View::make('backend.historyinformation.index', compact('contents'));
        } catch (Exception $e) {
            return $this->handleException($e, '/historyinformation');
        }
    }

    /**
     * Summary of create
     */
    public function create()
    {
        try {
          return View::make('backend.historyinformation.create');
        } catch (Exception $ex) {
          return $this->handleException($ex, '/historyinformation');
        }
    }

    /**
     * Summary of store
     */
    public function store()
    {
        try {
            $this->historyService->addContent();
            return $this->success('Content created successfully!', '/historyinformation');
        } catch (Exception $exception) {
            return $this->handleException($exception, '/historyinformation');
        }
    }

    /**
     * Summary of edit
     */
    public function edit()
    {
        try {
            $content_id = $_GET['id'];
            $content    = $this->historyService->getContentById($content_id);
            return View::make('backend.historyinformation.edit', compact('content'));
        } catch (Exception $exception) {
            return $this->handleException($exception, '/historyinformation');
        }
    }

    /**
     * Summary of update
     */
    public function update()
    {
        try{
            $this->historyService->updateContent();
            return $this->success('Content updated successfully!', '/historyinformation');
        }catch (Exception $exception) {
            return $this->handleException($exception, '/historyinformation');
        }
    }

    /**
     * Summary of delete
     */
    public function delete()
    {
        try {
            $contentId = $_GET['id'];
            $this->historyService->deleteContent($contentId);
            return $this->success('Content deleted successfully!', '/historyinformation');
        } catch (Exception $exception) {
            return $this->handleException($exception, '/historyinformation');
        }
    }
}
