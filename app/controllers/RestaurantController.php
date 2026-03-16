<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Services\FeatureService;
use App\Services\RestaurantService;
use App\Services\SessionService;
use Exception;

class RestaurantController
{
    private $restaurantService;
    private $sessionService;
    private $featureService;

    public function __construct()
    {
        $this->restaurantService = new RestaurantService();
        $this->sessionService = new SessionService();
        $this->featureService = new FeatureService();
    }

    public function index()
    {
        try {
            $restaurants = $this->restaurantService->getAllRestaurants();
            require __DIR__ . '/../views/backend/restaurants/index.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function create()
    {
        $events = $this->sessionService->getAllEvents();
        $features = $this->featureService->getAllFeatures();
        require __DIR__ . '/../views/backend/restaurants/create.php';
    }

    public function store()
    {
        try {
            $validateData = Helper::validate($_POST);
            $selectedFeatures = isset($_POST['features']) ? $_POST['features'] : [];

            $title = $validateData['title'];

            $imageUrl = '';

            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['image_url'];
                $imageUrl = Helper::uploadFile($file);
            }

            $description = $validateData['description'];
            $ratings = $validateData['ratings'];
            $cuisines = $validateData['cuisines'];
            $event_id = $validateData['event_id'];
            $location = $validateData['location'];
            $number_of_seats = $validateData['number_of_seats'];
            $contact_email = $validateData['contact_email'];
            $contact_phone = $validateData['contact_phone'];

            $galleryImages = [];

            if (!empty($_FILES['gallery_image_url']['name'])) {
                foreach ($_FILES['gallery_image_url']['name'] as $key => $name) {
                    if ($_FILES['gallery_image_url']['error'][$key] === UPLOAD_ERR_OK) {

                        $fileName = $_FILES['gallery_image_url']['name'][$key];
                        $tmpFilePath = $_FILES['gallery_image_url']['tmp_name'][$key];
                        $uploadDir = __DIR__ . '/../public/images/';

                        $newFileName = uniqid('', true) . '_' . $fileName;

                        $uploadPath = $uploadDir . $newFileName;

                        if (!move_uploaded_file($tmpFilePath, $uploadPath)) {
                            $_SESSION['isError'] = 1;
                            $_SESSION['flash_message'] = "Error uploading file: $fileName";
                            header("Location: /restaurant");
                            exit();
                        }

                        $uploadedImageUrl = '/images/' . $newFileName;

                        $galleryImages[] = $uploadedImageUrl;
                    }
                }
            }

            $galleryImagesJson = json_encode($galleryImages);

            $restaurantId = $this->restaurantService->createRestaurant($title, $imageUrl, $description, $ratings, $cuisines, $event_id, $location, $number_of_seats, $contact_email, $contact_phone, $galleryImagesJson);

            $this->restaurantService->associateFeaturesWithRestaurant($restaurantId, $selectedFeatures);

            Helper::setMessage(false, "Restaurant added successfully!");
            header("Location: /restaurant");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function view()
    {
        $id = $_GET['id'];
        if (isset($id) && $id > 0) {
            $restaurant = $this->restaurantService->getRestaurant($id);
            $sessions = $this->sessionService->getSessionsByRestaurantId($id);
            require __DIR__ . '/../views/backend/restaurants/view.php';
        } else {
            header("Location: /error?message=Something went wrong with this restaurant data!");
            exit();
        }
    }

    public function edit()
    {
        $id = $_GET['id'];
        if (isset($id) && $id > 0) {
            $events = $this->sessionService->getAllEvents();
            $features = $this->featureService->getAllFeatures();
            $selectedFeatures = $this->featureService->getAllFeaturesByRestaurantId($id);
            $restaurant = $this->restaurantService->getRestaurant($id);
            require __DIR__ . '/../views/backend/restaurants/edit.php';
        } else {
            header("Location: /error?message=Something went wrong with this restaurant data!");
            exit();
        }
    }

    public function update()
    {
        try {
            $id = $_POST['id'] ?? null;
            if (!$id || $id <= 0) {
                throw new Exception("Invalid restaurant ID provided.");
            }

            $validateData = Helper::validate($_POST);
            $selectedFeatures = isset($_POST['features']) ? $_POST['features'] : [];
            $existingRestaurant = $this->restaurantService->getRestaurant($id);
            $existingImageUrl = $existingRestaurant['image_url'];
            $imageUrl = $existingImageUrl;

            $restaurant = $this->restaurantService->getRestaurant($id);

            $title = $validateData['title'];

            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['image_url'];
                $imageUrl = Helper::uploadFile($file);
                Helper::unlinkImage($existingImageUrl);
            }

            $description = $validateData['description'];
            $ratings = $validateData['ratings'];
            $cuisines = $validateData['cuisines'];
            $event_id = $validateData['event_id'];
            $location = $validateData['location'];
            $number_of_seats = $validateData['number_of_seats'];
            $contact_email = $validateData['contact_email'];
            $contact_phone = $validateData['contact_phone'];

            $galleryImages = [];

            $previousGalleryImages = json_decode($restaurant['gallery_images'], true);

            if (!empty($previousGalleryImages)) {
                $galleryImages = $previousGalleryImages;
            }

            if (!empty($_FILES['gallery_image_url']['name'])) {
                foreach ($_FILES['gallery_image_url']['name'] as $key => $name) {
                    if ($_FILES['gallery_image_url']['error'][$key] === UPLOAD_ERR_OK) {
                        $fileName = $_FILES['gallery_image_url']['name'][$key];
                        $tmpFilePath = $_FILES['gallery_image_url']['tmp_name'][$key];
                        $uploadDir = __DIR__ . '/../public/images/';

                        $newFileName = uniqid('', true) . '_' . $fileName;
                        $uploadPath = $uploadDir . $newFileName;

                        if (!move_uploaded_file($tmpFilePath, $uploadPath)) {
                            throw new Exception("Error uploading file: $fileName");
                        }

                        $uploadedImageUrl = '/images/' . $newFileName;
                        $galleryImages[] = $uploadedImageUrl;
                    }
                }
            }

            $galleryImagesJson = json_encode($galleryImages);


            $galleryImagesJson = json_encode($galleryImages);

            $this->restaurantService->updateRestaurant($id, $title, $imageUrl, $description, $ratings, $cuisines, $event_id, $location, $number_of_seats, $contact_email, $contact_phone, $galleryImagesJson);

            $this->featureService->deleteFeatureByRestaurantId($id);
            $this->restaurantService->associateFeaturesWithRestaurant($id, $selectedFeatures);

            Helper::setMessage(false, "Restaurant updated successfully!");
            header("Location: /restaurant");
            exit();
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }

    public function delete()
    {
        $id = $_GET['id'];
        $existingRestaurant = $this->restaurantService->getRestaurant($id);
        $existingImageUrl = $existingRestaurant['image_url'];
        $existingGalleryImages = json_decode($existingRestaurant['gallery_images'], true);
        if (isset($id) && $id > 0) {
            Helper::unlinkImage($existingImageUrl);

            foreach ($existingGalleryImages as $galleryImage) {
                Helper::unlinkImage($galleryImage);
            }

            $this->restaurantService->deleteRestaurant($id);
            Helper::setMessage(false, "Restaurant deleted successfully!");
            header("Location: /restaurant");
            exit();
        } else {
            header("Location: /error?message=Something went wrong with this restaurant data!");
            exit();
        }
    }

    public function details()
    {
        $id = $_GET['id'];
        $restaurant = $this->restaurantService->getRestaurant($id);
        $sessions = $this->sessionService->getSessionsByRestaurantId($id);
        require '../views/frontend/yummy/details.php';
        exit();
    }
}
