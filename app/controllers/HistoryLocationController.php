<?php

namespace App\Controllers;

use App\Models\Location;
use App\Services\HistoryService;
use Exception;

class HistoryLocationController
{
    private HistoryService $historyService;

    public function __construct()
    {
        $this->historyService = new HistoryService();
    }

    public function index()
    {
        try {
            $locations = $this->historyService->getAllTourLocations();
            require_once __DIR__ . '/../views/backend/historylocations/index.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function edit()
    {
        try {
            $location_id = $_GET['id'];
            $location = $this->historyService->getTourLocationById($location_id);
            require_once __DIR__ . '/../views/backend/historylocations/edit.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }
    public function update()
    {
        try{
            $location_id = $_POST['tour_location_id'];
            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                // Process image upload
                $newFileName = uniqid('', true) . '_' . $_FILES['image_url']['name'];
                $uploadFile = __DIR__ . '/../public/images/' . $newFileName;

                $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png'];
                if (!in_array($imageFileType, $allowedExtensions)) {
                    throw new Exception('Invalid file format. Please upload a valid image file.');
                }

                if (!move_uploaded_file($_FILES['image_url']['tmp_name'], $uploadFile)) {
                    throw new Exception('Failed to upload image.');
                }

                $image_url = $newFileName;
            }else{
                $location = $this->historyService->getTourLocationById($location_id);
                $image_url = $location['images'];
            }
            $location = new Location(
                (int)$_POST['tour_location_id'],
                $_POST['location_name'],
                $_POST['description'],
                $_POST['address'],
                $_POST['contact_info'],
                $image_url
            );
            $this->historyService->updateLocation($location, $location_id);
            $_SESSION['isError'] = 0;
            $_SESSION['flash_message'] = "Location updated successfully!";
            header("Location: /historylocation");
            exit();
        }catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function create()
    {
        require_once __DIR__ . '/../views/backend/historylocations/create.php';
    }

    public function add()
    {
        try {
            $imageUrl = null;
            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['image_url'];
                $fileName = $file['name'];
                $newFileName = uniqid('', true) . '_' . $fileName;
                $uploadFile = __DIR__ . '/../public/images/' . $newFileName;
                $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                if (!in_array($imageFileType, $allowedExtensions)) {
                    throw new Exception('Invalid file format. Please upload a valid image file.');
                }
                if (!move_uploaded_file($file['tmp_name'], $uploadFile)) {
                    throw new Exception('Failed to upload image.');
                }
                $imageUrl = $newFileName;
            }
            $location = new Location(
                null,
                $_POST['location_name'],
                $_POST['description'],
                $_POST['address'],
                $_POST['contact_info'],
                $imageUrl
            );
            $this->historyService->addLocation($location);
            $_SESSION['isError'] = 0;
            $_SESSION['flash_message'] = "Location added successfully!";
            header("Location: /historylocation");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }
    public function delete()
    {
        try {
            $location_id = $_GET['id'];
            if(isset($location_id) && $location_id>0){
                $location = $this->historyService->getTourLocationById($location_id);
                $this->historyService->deleteLocation($location_id);
            }
            $_SESSION['isError'] = 0;
            $_SESSION['flash_message'] = "Location deleted successfully!";
            header("Location: /historylocation");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }
}