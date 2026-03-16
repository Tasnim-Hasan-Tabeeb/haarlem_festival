<?php

namespace App\Controllers;

use App\Models\HistoryContent;
use App\Services\HistoryService;
use Exception;

class HistoryInformationController
{
    private HistoryService $historyService;

    public function __construct()
    {
        $this->historyService = new HistoryService();
    }

    public function index()
    {
        try {
            $contents = $this->historyService->getAllContent();
            require_once __DIR__ . '/../views/backend/historyinformation/index.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function create()
    {
        require_once __DIR__ . '/../views/backend/historyinformation/create.php';
    }

    public function add()
    {
        try {
            $image = null;
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
                $image = $newFileName;
            }
            $content = new HistoryContent(
                null,
                $_POST['title'],
                $_POST['description'],
                $image,
                $_POST['url']
            );
            $this->historyService->addContent($content);
            $_SESSION['isError'] = 0;
            $_SESSION['flash_message'] = "Content added successfully!";
            header("Location: /historyinformation");
            exit();
        } catch (Exception $exception) {
            header("Location: /error?message=" . urlencode($exception->getMessage()));
            exit();
        }
    }

    public function edit()
    {
        try {
            $content_id = $_GET['id'];
            $content = $this->historyService->getContentById($content_id);
            require_once __DIR__ . '/../views/backend/historyinformation/edit.php';
        } catch (Exception $exception) {
            header("Location: /error?message=" . urlencode($exception->getMessage()));
            exit();
        }
    }

    public function update()
    {
        try{
            $content_id = $_POST['content_id'];
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
                $image = $newFileName;
            }
            else{
                $content = $this->historyService->getContentById($content_id);
                $image = $content['image'];
            }
            $content = new HistoryContent(
                $content_id,
                $_POST['title'],
                $_POST['description'],
                $image,
                $_POST['url']
            );
            $this->historyService->updateContent($content, $content_id);
            $_SESSION['isError'] = 0;
            $_SESSION['flash_message'] = "Content updated successfully!";
            header("Location: /historyinformation");
            exit();
        }catch (Exception $exception) {
            header("Location: /error?message=" . urlencode($exception->getMessage()));
            exit();
        }
    }

    public function delete()
    {
        try {
            $content_id = $_GET['id'];
            if (isset($content_id) && $content_id > 0) {
                $this->historyService->deleteContent($content_id);
                header("Location: /historyinformation");
                exit();
            }
            $_SESSION['isError'] = 0;
            $_SESSION['flash_message'] = "Content deleted successfully!";
            header("Location: /historyinformation");
            exit();
        } catch (Exception $exception) {
            header("Location: /error?message=" . urlencode($exception->getMessage()));
            exit();
        }
    }
}