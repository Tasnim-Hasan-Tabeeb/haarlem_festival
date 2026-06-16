<?php

namespace App\Services;

use App\Helpers\Validator;
use App\Models\Restaurant;
use App\Repositories\RestaurantRepository;
use App\Traits\Fileable;
use Exception;

class RestaurantService
{
    use Fileable;
    private RestaurantRepository $restaurantRepository;

    public function __construct()
    {
        $this->restaurantRepository = new RestaurantRepository();
    }

    public function getAllRestaurants()
    {
        try {
            return $this->restaurantRepository->getAllRestaurants();
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of createRestaurant
     * @throws Exception
     * @return bool|string
     */
    public function createRestaurant()
    {
        try {
            $rules = [
                'title'             => 'required|string|min:3|max:150',
                'description'       => 'required|string|min:1|max:100000',
                'ratings'           => 'required',
                'cuisines'          => 'required|string|min:2|max:200',
                'event_id'          => 'required|numeric',
                'location'          => 'required|string|min:3|max:255',
                'number_of_seats'   => 'required|numeric',
                'contact_email'     => 'required|email',
                'contact_phone'     => 'required|string',
                'price_for_child'   => 'required|numeric|min:0|max:10000000',
                'price_for_adult'   => 'required|numeric|min:0|max:10000000',
                'image_url'         => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
                'gallery_image_url' => 'required_array|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ];

            Validator::validate($_POST, $rules);
            $title    = $_POST['title'];
            $imageUrl = '/images/default.webp';

            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $file     = $_FILES['image_url'];
                $imageUrl = $this->uploadImage($file);
            }

            $description    = $_POST['description'];
            $ratings        = $_POST['ratings'];
            $cuisines       = $_POST['cuisines'];
            $eventId        = $_POST['event_id'];
            $location       = $_POST['location'];
            $numberOfSeats  = $_POST['number_of_seats'];
            $contactEmail   = $_POST['contact_email'];
            $contactPhone   = $_POST['contact_phone'];
            $priceForChild  = $_POST['price_for_child'];
            $priceFormAdult = $_POST['price_for_adult'];

            $galleryImages = [];

            if (!empty($_FILES['gallery_image_url']['name'])) {
                foreach ($_FILES['gallery_image_url']['name'] as $key => $name) {
                    if ($_FILES['gallery_image_url']['error'][$key] === UPLOAD_ERR_OK) {
                         $file = [
                                    'name'     => $_FILES['gallery_image_url']['name'][$key],
                                    'type'     => $_FILES['gallery_image_url']['type'][$key],
                                    'tmp_name' => $_FILES['gallery_image_url']['tmp_name'][$key],
                                    'error'    => $_FILES['gallery_image_url']['error'][$key],
                                    'size'     => $_FILES['gallery_image_url']['size'][$key],
                                ];

                        $galleryImages[] = $this->uploadImage($file);
                    }
                }
            }

            $galleryImagesJson = json_encode($galleryImages);

            $restaurant = new Restaurant();
            $restaurant->setTitle($title);
            $restaurant->setImageUrl($imageUrl);
            $restaurant->setDescription($description);
            $restaurant->setRatings($ratings);
            $restaurant->setCuisines($cuisines);
            $restaurant->setEventId($eventId);
            $restaurant->setLocation($location);
            $restaurant->setNumberOfSeats($numberOfSeats);
            $restaurant->setContactEmail($contactEmail);
            $restaurant->setContactPhone($contactPhone);
            $restaurant->setGalleryImages($galleryImagesJson);
            $restaurant->setPriceForChild($priceForChild);
            $restaurant->setPriceForAdult($priceFormAdult);

            return $this->restaurantRepository->createRestaurant($restaurant);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of associateFeaturesWithRestaurant
     * @param mixed $restaurantId
     * @param mixed $selectedFeatures
     * @return bool
     */
    public function associateFeaturesWithRestaurant($restaurantId, $selectedFeatures) {
        return $this->restaurantRepository->associateFeaturesWithRestaurant($restaurantId, $selectedFeatures);
    }

    /**
     * Summary of getRestaurant
     * @param mixed $restaurantId
     * @throws Exception
     */
    public function getRestaurant($restaurantId)
    {
        try {
            return $this->restaurantRepository->getRestaurant($restaurantId);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of updateRestaurant
     * @throws Exception
     * @return bool
     */
    public function updateRestaurant()
    {
        try {
            $rules = [
                'id'              => 'required|numeric',
                'title'           => 'required|string|min:3|max:150',
                'description'     => 'required|string|min:1|max:100000',
                'ratings'         => 'required',
                'cuisines'        => 'required|string|min:2|max:200',
                'event_id'        => 'required|numeric',
                'location'        => 'required|string|min:3|max:255',
                'number_of_seats' => 'required|numeric',
                'contact_email'   => 'required|email',
                'contact_phone'   => 'required|string',
                'price_for_child' => 'required|numeric|min:0|max:10000000',
                'price_for_adult' => 'required|numeric|min:0|max:10000000',
                'image_url'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            ];

            Validator::validate($_POST, $rules);

            $id               = $_POST['id'];
            $restaurant       = $this->getRestaurant($id);
            $existingImageUrl = $restaurant['image_url'];
            $imageUrl         = $existingImageUrl;
            $title            = $_POST['title'];

            if (isset($_FILES['image_url']) && $_FILES['image_url']['error'] === UPLOAD_ERR_OK) {
                $file = $_FILES['image_url'];
                $this->unlinkImage($existingImageUrl);
                $imageUrl = $this->uploadImage($file);
            }

            $description    = $_POST['description'];
            $ratings        = $_POST['ratings'];
            $cuisines       = $_POST['cuisines'];
            $eventId        = $_POST['event_id'];
            $location       = $_POST['location'];
            $numberOfSeats  = $_POST['number_of_seats'];
            $contactEmail   = $_POST['contact_email'];
            $contactPhone   = $_POST['contact_phone'];
            $priceForChild  = $_POST['price_for_child'];
            $priceFormAdult = $_POST['price_for_adult'];

            $galleryImages         = [];
            $previousGalleryImages = json_decode($restaurant['gallery_images'], true);
            $galleryImages         = $previousGalleryImages;

            $galleryImages         = json_decode($restaurant['gallery_images'], true) ?? [];
            $previousGalleryImages = $galleryImages;

            $hasNewGalleryImages = !empty(array_filter($_FILES['gallery_image_url']['name'] ?? []));

            if ($hasNewGalleryImages) {
                // delete old images only if new ones exist
                foreach ($previousGalleryImages as $image) {
                    $this->unlinkImage($image);
                }

                $galleryImages = [];

                foreach ($_FILES['gallery_image_url']['name'] as $key => $name) {
                    if ($_FILES['gallery_image_url']['error'][$key] === UPLOAD_ERR_OK && !empty($name)) {
                        $file = [
                            'name'     => $_FILES['gallery_image_url']['name'][$key],
                            'type'     => $_FILES['gallery_image_url']['type'][$key],
                            'tmp_name' => $_FILES['gallery_image_url']['tmp_name'][$key],
                            'error'    => $_FILES['gallery_image_url']['error'][$key],
                            'size'     => $_FILES['gallery_image_url']['size'][$key],
                        ];

                        $galleryImages[] = $this->uploadImage($file);
                    }
                }
            }

            $galleryImagesJson = json_encode($galleryImages);

            $restaurant = new Restaurant();
            $restaurant->setRestaurantId($id);
            $restaurant->setTitle($title);
            $restaurant->setImageUrl($imageUrl);
            $restaurant->setDescription($description);
            $restaurant->setRatings($ratings);
            $restaurant->setCuisines($cuisines);
            $restaurant->setEventId($eventId);
            $restaurant->setLocation($location);
            $restaurant->setNumberOfSeats($numberOfSeats);
            $restaurant->setContactEmail($contactEmail);
            $restaurant->setContactPhone($contactPhone);
            $restaurant->setGalleryImages($galleryImagesJson);
            $restaurant->setPriceForChild($priceForChild);
            $restaurant->setPriceForAdult($priceFormAdult);

            return $this->restaurantRepository->updateRestaurant($restaurant);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of deleteRestaurant
     * @param mixed $restaurantId
     * @throws Exception
     * @return bool
     */
    public function deleteRestaurant($restaurantId)
    {
        try {
            $existingRestaurant    = $this->getRestaurant($restaurantId);
            $existingImageUrl      = $existingRestaurant['image_url'];
            $existingGalleryImages = json_decode($existingRestaurant['gallery_images'], true);

            $this->unlinkImage($existingImageUrl);

            foreach ($existingGalleryImages as $galleryImage) {
                $this->unlinkImage($galleryImage);
            }
            return $this->restaurantRepository->deleteRestaurant($restaurantId);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

   /**
    * Summary of unlinkGalleryImage
    * @param mixed $id
    * @throws Exception
    * @return bool
    */
    public function unlinkGalleryImage($id)
    {
        try {
            $imageToUnlink = $_GET['image'] ?? null;

            if (!$imageToUnlink) {
                throw new Exception('Image is required');
            }

            $restaurant = $this->getRestaurant($id);

            $galleryImages = json_decode($restaurant['gallery_images'], true) ?? [];

            // remove selected image from array
            $updatedGalleryImages = array_filter($galleryImages, function ($image) use ($imageToUnlink) {
                return $image !== $imageToUnlink;
            });

            // reset array keys
            $updatedGalleryImages = array_values($updatedGalleryImages);

            // unlink physical file
            $this->unlinkImage($imageToUnlink);

            // update restaurant
            $newRestaurant = new Restaurant();
            $newRestaurant->setRestaurantId($id);
            $newRestaurant->setTitle($restaurant['title']);
            $newRestaurant->setImageUrl($restaurant['image_url']);
            $newRestaurant->setDescription($restaurant['description']);
            $newRestaurant->setRatings($restaurant['ratings']);
            $newRestaurant->setCuisines($restaurant['cuisines']);
            $newRestaurant->setEventId($restaurant['event_id']);
            $newRestaurant->setLocation($restaurant['location']);
            $newRestaurant->setNumberOfSeats($restaurant['number_of_seats']);
            $newRestaurant->setContactEmail($restaurant['contact_email']);
            $newRestaurant->setContactPhone($restaurant['contact_phone']);
            $newRestaurant->setGalleryImages(json_encode($updatedGalleryImages));
            $newRestaurant->setPriceForChild($restaurant['price_for_child']);
            $newRestaurant->setPriceForAdult($restaurant['price_for_adult']);

            return $this->restaurantRepository->updateRestaurant($newRestaurant);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }
}
