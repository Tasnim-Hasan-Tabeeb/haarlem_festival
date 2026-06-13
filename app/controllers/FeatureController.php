<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\View;
use App\Services\FeatureService;
use Exception;

class FeatureController extends Controller
{
    private FeatureService $featureService;

    public function __construct()
    {
        $this->featureService = new FeatureService();
    }

    /**
     * Summary of index
     */
    public function index()
    {
        try {
            $features = $this->featureService->getAllFeatures();
            return View::make('backend.features.index', compact('features'));
        } catch (Exception $e) {
           return $this->handleException($e, '/feature');
        }
    }

    /**
     * Summary of create
     */
    public function create()
    {
        try {
            return View::make('backend.features.create');
        } catch (Exception $e) {
            return $this->handleException($e, '/feature');
        }
    }

    /**
     * Summary of store
     */
    public function store()
    {
        try {
            $this->featureService->createFeature();
            return $this->success('Feature saved successfully!', '/feature');
        } catch (Exception $e) {
            return $this->handleException($e, '/feature');
        }
    }

    /**
     * Summary of edit
     */
    public function edit()
    {
        try {
           $id      = $_GET['id'];
           $feature = $this->featureService->getFeature($id);
           return View::make('backend.features.edit', compact('feature'));
        } catch (Exception $e) {
            return $this->handleException($e, '/feature');
        }
    }

    /**
     * Summary of update
     */
    public function update()
    {
        try {
            $this->featureService->updateFeature();
            return $this->success('Feature updated successfully!', '/feature');
        } catch (Exception $e) {
           return $this->handleException($e, '/feature');
        }
    }

    /**
     * Summary of delete
     */
    public function delete()
    {
        try {
            $id = $_GET['id'];
            $this->featureService->deleteFeature($id);
            return $this->success('Feature deleted successfully!', '/feature');
        } catch (Exception $e) {
           return $this->handleException($e, '/feature');
        }
    }
}
