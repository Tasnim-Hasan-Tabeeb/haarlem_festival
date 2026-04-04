<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Models\Dance;
use App\Models\SessionType;
use App\Services\ArtistService;
use App\Services\DanceService;
use App\Services\VenueService;
use Exception;

class DanceManagementController
{
    private DanceService $danceService;
    private VenueService $venueService;
    private ArtistService $artistService;
    private SessionType $sessionType;

    public function __construct()
    {
        $this->danceService = new DanceService();
        $this->venueService = new VenueService();
        $this->artistService = new ArtistService();
        $this->sessionType = new SessionType();
    }



    public function index()
    {
        try {
            $dancesManages = $this->danceService->getAllEvents();
            require __DIR__ . '/../views/backend/danceManagement/index.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function edit()
    {
        $id = $_GET['id'];

        // Fetch the dance event details
        $dance = $this->danceService->getDanceEventById($id);

        // Fetch session types
        $sessionTypes = SessionType::getAll();

        // Fetch venues
        $venues = $this->venueService->getAllVenues();
        $venue_id = $dance['venue_id'];

        // Fetch artists

        $artists = $this->artistService->getAllArtists();

        // Convert comma-separated string of artist IDs into an array
        $selectedArtistIds = explode(',', $dance['artist_id']);

        // Render the edit view with all necessary data
        require __DIR__ . '/../views/backend/danceManagement/edit.php';
    }

    public function update()
    {
        try {
            $musicPerformanceId = (int)($_POST['music_performance_id'] ?? 0);

            if ($musicPerformanceId <= 0) {
                throw new Exception('Music performance ID is required.');
            }

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

            $artistIds = $_POST['artist_id'] ?? [];
            $artistIds = array_values(array_filter(array_map('intval', $artistIds)));

            $this->danceService->updateManagedEvent(
                $musicPerformanceId,
                $_POST['title'],
                $_POST['event_date'],
                $_POST['event_start_time'],
                (float)$_POST['event_price'],
                (int)$_POST['event_duration'],
                $_POST['session_type'],
                (int)$_POST['venue_name'],
                $artistIds,
                $imageUrl
            );

            header("Location: /dancemanagement");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

}
