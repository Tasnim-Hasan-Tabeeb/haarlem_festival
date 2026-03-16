<?php

namespace App\Services;

use App\Models\Restaurant;
use App\Repositories\RestaurantRepository;
use Exception;

class RestaurantService
{
    private $restaurantRepository;

    public function __construct()
    {
        $this->restaurantRepository = new RestaurantRepository();
    }

    public function getAllRestaurants()
    {
        try {
            return $this->restaurantRepository->getAllRestaurants();
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function createRestaurant($title, $image_url, $description, $ratings, $cuisines, $event_id, $location, $number_of_seats, $contact_email, $contact_phone, $galleryImagesJson)
    {
        try {
            $restaurant = new Restaurant();
            $restaurant->setTitle($title);
            $restaurant->setImageUrl($image_url);
            $restaurant->setDescription($description);
            $restaurant->setRatings($ratings);
            $restaurant->setCuisines($cuisines);
            $restaurant->setEventId($event_id);
            $restaurant->setLocation($location);
            $restaurant->setNumberOfSeats($number_of_seats);
            $restaurant->setContactEmail($contact_email);
            $restaurant->setContactPhone($contact_phone);
            $restaurant->setGalleryImages($galleryImagesJson);
            
            return $this->restaurantRepository->createRestaurant($restaurant);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function associateFeaturesWithRestaurant($restaurantId, $selectedFeatures) {
        return $this->restaurantRepository->associateFeaturesWithRestaurant($restaurantId, $selectedFeatures);
    }

    public function getRestaurant($restaurantId)
    {
        try {
            return $this->restaurantRepository->getRestaurant($restaurantId);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function updateRestaurant($restaurantId, $title, $image_url, $description, $ratings, $cuisines, $event_id, $location, $number_of_seats, $contact_email, $contact_phone, $galleryImagesJson)
    {
        try {
            $restaurant = new Restaurant();
            $restaurant->setRestaurantId($restaurantId);
            $restaurant->setTitle($title);
            $restaurant->setImageUrl($image_url);
            $restaurant->setDescription($description);
            $restaurant->setRatings($ratings);
            $restaurant->setCuisines($cuisines);
            $restaurant->setEventId($event_id);
            $restaurant->setLocation($location);
            $restaurant->setNumberOfSeats($number_of_seats);
            $restaurant->setContactEmail($contact_email);
            $restaurant->setContactPhone($contact_phone);
            $restaurant->setGalleryImages($galleryImagesJson);

            return $this->restaurantRepository->updateRestaurant($restaurant);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function deleteRestaurant($restaurantId)
    {
        try {
            return $this->restaurantRepository->deleteRestaurant($restaurantId);
        } catch (Exception $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}