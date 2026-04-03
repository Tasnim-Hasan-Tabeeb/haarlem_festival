<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Models\Venue;
use App\Services\VenueService;
use Exception;

class VenueController
{

    private VenueService $venueService;

    public function __construct()
    {
        $this->venueService = new VenueService();
    }

    public function index()
    {
        try {
            $venues = $this->venueService->getAllVenues();
            require __DIR__ . '/../views/backend/venues/index.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function create()
    {
        try {
            require_once __DIR__ . '/../views/backend/venues/create.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function store()
    {
        try {
            $imageUrl = null;

            if (isset($_FILES['venue_image']) && $_FILES['venue_image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['venue_image'];
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

            $venue = new Venue(null, $_POST['name'], $_POST['location'], $_POST['capacity'], $_POST['map_url'], $imageUrl);
            $this->venueService->storeVenue($venue);
            header("Location: /venue");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function edit()
    {
        try {
            $venue_id = $_GET['id'];
            $venue = $this->venueService->getVenuesById($venue_id);
            require_once __DIR__ . '/../views/backend/venues/edit.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function update()
    {
        try {
            $venue_id = $_POST['venue_id'];

            $venue = $this->venueService->getVenuesById($venue_id);

            if (!$venue) {
                throw new Exception('Venue not found.');
            }

            $image_url = $venue['venue_image'];

            if (isset($_FILES['venue_image']) && $_FILES['venue_image']['error'] === UPLOAD_ERR_OK) {
                // Process image upload
                $newFileName = uniqid('', true) . '_' . $_FILES['venue_image']['name'];
                $uploadFile = __DIR__ . '/../public/images/' . $newFileName;

                $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png'];
                if (!in_array($imageFileType, $allowedExtensions)) {
                    throw new Exception('Invalid file format. Please upload a valid image file.');
                }

                if (!move_uploaded_file($_FILES['venue_image']['tmp_name'], $uploadFile)) {
                    throw new Exception('Failed to upload image.');
                }

                $image_url = $newFileName;
            }

            $venue = new Venue(
                $venue_id,
                $_POST['name'],
                $_POST['location'],
                $_POST['capacity'],
                $_POST['map_url'],
                $image_url
            );

            $this->venueService->updateVenue($venue, $venue_id);

            $_SESSION['isError'] = 0;
            $_SESSION['flash_message'] = "Venue updated successfully!";
            header("Location: /venue");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }
    public function delete()
    {
        $venueId = $_GET['id'];
        if (isset($venueId) && $venueId > 0) {
            $venue = $this->venueService->getVenuesById($venueId);
            $this->venueService->deleteVenue($venueId);
            header("Location: /venue");
            exit();
        } else {
            header("Location: /error?message=something went wrong with this user data!");
            exit();
        }
    }
}