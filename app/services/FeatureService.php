<?php

namespace App\Services;

use App\Models\Feature;
use App\Repositories\FeatureRepository;
use Exception;

class FeatureService
{
    private $featureRepository;

    public function __construct()
    {
        $this->featureRepository = new FeatureRepository();
    }

    public function getAllFeaturesByRestaurantId($restaurantId)
    {
        try {
            return $this->featureRepository->getAllFeaturesByRestaurantId($restaurantId);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    
    public function deleteFeatureByRestaurantId($restaurantId)
    {
        try {
            return $this->featureRepository->deleteFeatureByRestaurantId($restaurantId);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    
    public function getAllFeatures()
    {
        try {
            return $this->featureRepository->getAllFeatures();
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function createFeature($imageUrl, $name)
    {
        try {
            $feature = new Feature();
            $feature->setImageUrl($imageUrl);
            $feature->setName($name);
            return $this->featureRepository->createFeature($feature);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getFeature($feature_id)
    {
        try {
            return $this->featureRepository->getFeature($feature_id);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function updateFeature($feature_id, $imageUrl, $name)
    {
        try {
            $feature = new Feature();
            $feature->setFeatureId($feature_id);
            $feature->setImageUrl($imageUrl);
            $feature->setName($name);
            return $this->featureRepository->updateFeature($feature);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function deleteFeature($feature_id)
    {
        try {
            return $this->featureRepository->deleteFeature($feature_id);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}
