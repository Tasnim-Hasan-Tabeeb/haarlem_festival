<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Models\Events;
use App\Models\EventTypes;
use App\Services\EventService;
use Exception;

class EventsController{
    private EventService $eventService;

    public function __construct()
    {
        $this->eventService = new EventService();
    }

    public function index()
    {
        try {
            $events = $this->eventService->getAll();
            require __DIR__ . '/../views/backend/events/index.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function create()
    {
        $eventtypes = EventTypes::getEnumValues();
        require '../views/backend/events/create.php';
    }

    public function edit()
    {
        $event_id = $_GET['id'];
        $eventtypes = EventTypes::getEnumValues();
        $event = $this->eventService->getEventById($event_id);
        require __DIR__ . '/../views/backend/events/edit.php';
    }

    public function store()
    {
        try {
            $imageUrl = null;

            if (isset($_FILES['image_url'])) {
                $file = $_FILES['image_url'];
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    $errorMessages = [
                        UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                        UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
                        UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
                        UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
                        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
                        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
                    ];
                    $errorMessage = isset($errorMessages[$file['error']]) ? $errorMessages[$file['error']] : 'Unknown upload error.';
                    throw new Exception('File upload error: ' . $errorMessage);
                }
                $fileName = $file['name'];
                $newFileName = uniqid('', true) . '_' . $fileName;
                $uploadFile = __DIR__ . '/../public/images/' . $newFileName;

                $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];

                if (!in_array($imageFileType, $allowedExtensions)) {
                    throw new Exception('Invalid file format. Please upload a valid image file.');
                }

                if (!move_uploaded_file($file['tmp_name'], $uploadFile)) {
                    throw new Exception('Failed to upload image. Check directory permissions.');
                }
                $imageUrl = $newFileName;
            }

            $event = new Events(
                null,
                $_POST['event_type'] ?? '',
                $_POST['title'] ?? '',
                $imageUrl ?? '',
                $_POST['description'] ?? '',
                '',
                $_POST['start_date'] ?? '',
                $_POST['end_date'] ?? '',
                $_POST['primary_theme_color'] ?? '',
                $_POST['secondary_theme_color'] ?? ''
            );

            $this->eventService->storeEvent($event);

            $_SESSION['isError'] = 0;
            $_SESSION['flash_message'] = "Event created successfully!";
            header("Location: /events");
            exit();
        } catch (Exception $e) {
            $_SESSION['isError'] = 1;
            $_SESSION['flash_message'] = $e->getMessage();
            header("Location: /events/create");
            exit();
        }
    }

    public function update()
    {
        try {
            $event_id = $_POST['event_id'];

            $image_url = null;
            if (isset($_FILES['image_url'])) {
                $file = $_FILES['image_url'];
                if ($file['error'] !== UPLOAD_ERR_OK) {
                    if ($file['error'] !== UPLOAD_ERR_NO_FILE) {
                        $errorMessages = [
                            UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
                            UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
                            UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
                            UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.',
                            UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
                            UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.',
                        ];
                        $errorMessage = isset($errorMessages[$file['error']]) ? $errorMessages[$file['error']] : 'Unknown upload error.';
                        throw new Exception('File upload error: ' . $errorMessage);
                    }
                } else {
                    $newFileName = uniqid('', true) . '_' . $file['name'];
                    $uploadFile = __DIR__ . '/../public/images/' . $newFileName;

                    $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
                    $allowedExtensions = ['jpg', 'jpeg', 'png'];
                    if (!in_array($imageFileType, $allowedExtensions)) {
                        throw new Exception('Invalid file format. Please upload a valid image file.');
                    }

                    if (!move_uploaded_file($file['tmp_name'], $uploadFile)) {
                        throw new Exception('Failed to upload image. Check directory permissions.');
                    }
                    $image_url = $newFileName;
                }
            }
            if ($image_url === null) {
                $event = $this->eventService->getEventById($event_id);
                $image_url = $event['image_url'];
            }

            $event = new Events(
                (int)$_POST['event_id'],
                $_POST['event_type'] ?? '',
                $_POST['title'] ?? '',
                $image_url ?? '',
                $_POST['description'] ?? '',
                1,
                $_POST['start_date'] ?? '',
                $_POST['end_date'] ?? '',
                $_POST['primary_theme_color'] ?? '',
                $_POST['secondary_theme_color'] ?? ''
            );

            $this->eventService->updateEvent($event, $event_id);

            $_SESSION['isError'] = 0;
            $_SESSION['flash_message'] = "Event updated successfully!";
            header("Location: /events");
            exit();
        } catch (Exception $e) {
            $_SESSION['isError'] = 1;
            $_SESSION['flash_message'] = $e->getMessage();
            header("Location: /events/edit?id=" . $event_id);
            exit();
        }
    }
    public function delete()
    {
        $eventId = $_GET['id'];
        if (isset($eventId) && $eventId > 0) {
            $artist = $this->eventService->getEventById($eventId);
            $this->eventService->deleteEvent($eventId);
            header("Location: /events");
            exit();
        } else {
            header("Location: /error?message=something went wrong with this user data!");
            exit();
        }
    }
}