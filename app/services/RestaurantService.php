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
}