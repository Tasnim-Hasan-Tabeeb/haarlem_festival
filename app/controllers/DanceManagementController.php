<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Models\Dance;
use App\Models\SessionType;
use App\Services\ArtistService;
use App\Services\DanceService;
use App\Services\VenueService;
use App\Services\MusicEventService;
use Exception;

class DanceManagementController
{
    private DanceService $danceService;
    private VenueService $venueService;
    private ArtistService $artistService;
    private SessionType $sessionType;
    private MusicEventService $musicEventService;

    public function __construct()
    {
        $this->danceService = new DanceService();
        $this->venueService = new VenueService();
        $this->artistService = new ArtistService();
        $this->sessionType = new SessionType();
        $this->musicEventService = new MusicEventService();
    }



    public function index()
    {
        try {
            $dancesManages = $this->musicEventService->getAll();
            require __DIR__ . '/../views/backend/danceManagement/index.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function edit()
    {
        $id = $_GET['id'];

        // Fetch the music event details
        $dance = $this->musicEventService->getById((int)$id);

        // Fetch session types
        $sessionTypes = SessionType::getAll();

        // Fetch venues
        $venues = $this->venueService->getAllVenues();
        $venue_id = $dance['venue_id'];

        // Fetch artists

        $artists = $this->artistService->getAllArtists();

        // Render the edit view with all necessary data
        require __DIR__ . '/../views/backend/danceManagement/edit.php';
    }


    public function update($id = null)
    {
        try {
            $musicEventId = isset($_POST['music_event_id']) ? (int)$_POST['music_event_id'] : (int)$id;

            // Handle optional image upload (keep old if none)
            $current = $this->musicEventService->getById($musicEventId);
            $imageName = $current['music_event_image'] ?? null;
            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['image_url'];
                $newFileName = uniqid('', true) . '_' . $file['name'];
                $uploadPath = __DIR__ . '/../public/images/' . $newFileName;
                move_uploaded_file($file['tmp_name'], $uploadPath);
                $imageName = $newFileName;
            }

            $data = [
                'artist_id'        => (int)($_POST['artist_id'] ?? 0),
                'venue_id'         => (int)($_POST['venue_id'] ?? 0),
                'event_date'       => $_POST['event_date'] ?? '',
                'event_name'       => $_POST['title'] ?? '',
                'event_price'      => (float)($_POST['event_price'] ?? 0),
                'session_type'     => $_POST['session_type'] ?? '',
                'event_start_time' => $_POST['event_start_time'] ?? '',
                'event_duration'   => (int)($_POST['event_duration'] ?? 0),
                'music_event_image'=> $imageName,
            ];

            $this->musicEventService->update($musicEventId, $data);

            $_SESSION['isError'] = 0;
            $_SESSION['flash_message'] = "Music event updated successfully!";
            header("Location: /dancemanagement");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }


    public function create()
    {
        try {

            // Fetch session types
            $sessionTypes = SessionType::getAll();

            // Fetch venues
            $venues = $this->venueService->getAllVenues();
            $artists = $this->artistService->getAllArtists();
            require __DIR__ . '/../views/backend/danceManagement/create.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function store()
    {
        try {
            // Handle optional image upload
            $imageName = null;
            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['image_url'];
                $newFileName = uniqid('', true) . '_' . $file['name'];
                $uploadPath = __DIR__ . '/../public/images/' . $newFileName;
                move_uploaded_file($file['tmp_name'], $uploadPath);
                $imageName = $newFileName;
            }

            $data = [
                'event_id'         => null,
                'artist_id'        => (int)($_POST['artist'] ?? 0),
                'venue_id'         => (int)($_POST['venue'] ?? 0),
                'event_date'       => $_POST['event_date'] ?? '',
                'event_name'       => $_POST['title'] ?? '',
                'event_price'      => (float)($_POST['price'] ?? 0),
                'session_type'     => $_POST['event_type'] ?? '',
                'event_start_time' => $_POST['event_time'] ?? '',
                'event_duration'   => (int)($_POST['duration'] ?? 0),
                'music_event_image'=> $imageName,
            ];

            $this->musicEventService->createMusicEvent($data);

            $_SESSION['isError'] = 0;
            $_SESSION['flash_message'] = "Music event created successfully!";
            header("Location: /dancemanagement");
            exit();
        } catch (Exception $e) {
            $_SESSION['isError'] = 1;
            $_SESSION['flash_message'] = $e->getMessage();
            header("Location: /dancemanagement/create");
            exit();
        }
    }

    public function delete()
    {
        try {
            $musicEventId = (int)($_GET['id'] ?? 0);

            if ($musicEventId <= 0) {
                throw new Exception('Invalid music event ID.');
            }

            $dance = $this->musicEventService->getById($musicEventId);
            if (!$dance) {
                throw new Exception('Music event not found.');
            }

            $this->musicEventService->delete($musicEventId);

            $_SESSION['isError'] = 0;
            $_SESSION['flash_message'] = "Music event deleted successfully!";
            header("Location: /dancemanagement");
            exit();
        } catch (Exception $e) {
            $_SESSION['isError'] = 1;
            $_SESSION['flash_message'] = $e->getMessage();
            header("Location: /dancemanagement");
            exit();
        }
    }

}
