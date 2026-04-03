<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Models\Artist;
use App\Services\ArtistService;
use Exception;

class ArtistController
{
    private ArtistService $artistService;

    public function __construct()
    {
        $this->artistService = new ArtistService();
    }
    public function index()
    {
        try {
            $artists = $this->artistService->getAllArtists();
            require __DIR__ . '/../views/backend/artists/index.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }
    public function create()
    {
        try {
            require_once __DIR__ . '/../views/backend/artists/create.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }    }

    public function store()
    {
        try {
            $imageUrl = null;
            $detailImage = null;
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
            if (isset($_FILES['detail_image']) && $_FILES['detail_image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['detail_image'];
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

                $detailImage = $newFileName;
            }

            $artist = new Artist(
                null,
                $_POST['name'],
                $_POST['real-name'],
                $_POST['age'],
                $_POST['nationality'],
                $_POST['genre'],
                $_POST['about'],
                $imageUrl,
                $detailImage
            );

            $this->artistService->storeArtist($artist);

            header("Location: /artist");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }


    public function edit()
    {
        try {
            $artist_id = $_GET['id'];
            $artists = $this->artistService->getArtistsById($artist_id);
            require_once __DIR__ . '/../views/backend/artists/edit.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function update()
    {
        try {
            $artist_id = $_POST['artist_id'];

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
            } else {
                $artist = $this->artistService->getArtistsById($artist_id);
                $image_url = $artist['image_url'];
            }
            if (isset($_FILES['detail_image']) && $_FILES['detail_image']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['detail_image'];
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

                $detailImage = $newFileName;
            }else {
                $artist = $this->artistService->getArtistsById($artist_id);
                $detailImage = $artist['detail_image'];
            }

            $artist = new Artist(
                null,
                $_POST['name'],
                $_POST['real-name'],
                $_POST['age'],
                $_POST['nationality'],
                $_POST['genre'],
                $_POST['about'],
                $_POST['real-name'],
                $image_url,
                $detailImage
            );

            $this->artistService->updateArtist($artist, $artist_id);

            $_SESSION['isError'] = 0;
            $_SESSION['flash_message'] = "Artist updated successfully!";
            header("Location: /artist");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }
    public function delete()
    {
        $artistId = $_GET['id'];
        if (isset($artistId) && $artistId > 0) {
            $artist = $this->artistService->getArtistsById($artistId);
            $this->artistService->deleteArtist($artistId);
            header("Location: /artist");
            exit();
        } else {
            header("Location: /error?message=something went wrong with this user data!");
            exit();
        }
    }
}