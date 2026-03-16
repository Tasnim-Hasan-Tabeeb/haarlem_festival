<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Services\FeatureService;
use Exception;

class FeatureController
{
    private $featureService;

    public function __construct()
    {
        $this->featureService = new FeatureService();
    }

    public function index()
    {
        try {
            $features = $this->featureService->getAllFeatures();
            require __DIR__ . '/../views/backend/features/index.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function create()
    {
        require __DIR__ . '/../views/backend/features/create.php';
    }

    public function store()
    {
        try {
            $validatedData = Helper::validate($_POST);

            $name = $validatedData['name'];
            $imageUrl = '';

            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['image_url'];
                $imageUrl = Helper::uploadFile($file);
            }

            $this->featureService->createFeature($imageUrl, $name);

            Helper::setMessage(false, "Feature added successfully!");
            header("Location: /feature");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function edit()
    {
        $id = $_GET['id'];
        if (isset($id) && $id > 0) {
            $feature = $this->featureService->getFeature($id);
            require __DIR__ . '/../views/backend/features/edit.php';
        } else {
            header("Location: /error?message=something went wrong with this feature data!");
            exit();
        }
    }

    public function update()
    {
        try {
            $validatedData = Helper::validate($_POST);

            $id = $_POST['id'];
            $name = $validatedData['name'];
            $existingFeature = $this->featureService->getFeature($id);
            $existingImageUrl = $existingFeature['image_url'];

            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['image_url'];

                $imageUrl = Helper::uploadFile($file);

                Helper::unlinkImage($existingImageUrl);

                $this->featureService->updateFeature($id, $imageUrl, $name);
              
            } else {
                $this->featureService->updateFeature($id, $existingImageUrl, $name);
            }

            Helper::setMessage(false, "Feature updated successfully!");
            header("Location: /feature");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function delete()
    {
        $id = $_GET['id'];
        $existingFeature = $this->featureService->getFeature($id);
        $existingImageUrl = $existingFeature['image_url'];
        if (isset($id) && $id > 0) {
            Helper::unlinkImage($existingImageUrl);
            $this->featureService->deleteFeature($id);
            Helper::setMessage(false, "Feature deleted successfully!");
            header("Location: /feature");
            exit();
        } else {
            header("Location: /error?message=something went wrong with this feature data!");
            exit();
        }
    }
}
