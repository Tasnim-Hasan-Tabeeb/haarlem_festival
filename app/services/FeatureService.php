<?php

namespace App\Services;

use App\Helpers\Validator;
use App\Models\Feature;
use App\Repositories\FeatureRepository;
use App\Traits\Fileable;
use Exception;

class FeatureService
{
    use Fileable;
    private FeatureRepository $featureRepository;

    public function __construct()
    {
        $this->featureRepository = new FeatureRepository();
    }

    /**
     * Summary of getAllFeaturesByRestaurantId
     * @param mixed $restaurantId
     * @throws Exception
     * @return array
     */
    public function getAllFeaturesByRestaurantId($restaurantId)
    {
        try {
            return $this->featureRepository->getAllFeaturesByRestaurantId($restaurantId);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of deleteFeatureByRestaurantId
     * @param mixed $restaurantId
     * @throws Exception
     * @return bool
     */
    public function deleteFeatureByRestaurantId($restaurantId)
    {
        try {
            return $this->featureRepository->deleteFeatureByRestaurantId($restaurantId);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    public function getAllFeatures()
    {
        try {
            return $this->featureRepository->getAllFeatures();
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of createFeature
     * @throws Exception
     * @return bool
     */
    public function createFeature()
    {
        try {
            $rules = [
                'name'      => 'required|string',
                'image_url' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ];

            Validator::validate($_POST, $rules);

            $name     = $_POST['name'] ;
            $imageUrl = '/images/default.webp';

            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $file     = $_FILES['image_url'];
                $imageUrl = $this->uploadImage($file);
            }

            $feature = new Feature();
            $feature->setImageUrl($imageUrl);
            $feature->setName($name);
            return $this->featureRepository->createFeature($feature);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of getFeature
     * @param mixed $featureId
     * @throws Exception
     */
    public function getFeature($featureId)
    {
        try {
            return $this->featureRepository->getFeature($featureId);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of updateFeature
     * @throws Exception
     * @return bool
     */
    public function updateFeature()
    {
        try {
            $rules = [
                'id'        => 'required|numeric',
                'name'      => 'required|string',
                'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ];

            Validator::validate($_POST, $rules);

            $id              = $_POST['id'];
            $name            = $_POST['name'];
            $existingFeature = $this->getFeature($id);
            $imageUrl        = $existingFeature['image_url'];

            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['image_url'];
                $this->unlinkImage($imageUrl);
                $imageUrl = $this->uploadImage($file);
            }

            $feature = new Feature();
            $feature->setFeatureId($id);
            $feature->setImageUrl($imageUrl);
            $feature->setName($name);
            return $this->featureRepository->updateFeature($feature);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of deleteFeature
     * @param mixed $featureId
     * @throws Exception
     * @return bool
     */
    public function deleteFeature($featureId)
    {
        try {
            $existingFeature  = $this->getFeature($featureId);
            $existingImageUrl = $existingFeature['image_url'];
            $this->unlinkImage($existingImageUrl);
            return $this->featureRepository->deleteFeature($featureId);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }
}
