<?php

namespace App\Repositories;

use App\Models\Restaurant;
use Exception;
use PDO;
use PDOException;
use App\Services\SessionService;

class RestaurantRepository extends Repository
{
    private $sessionService; // Add this line

    public function __construct()
    {
        parent::__construct();
        $this->sessionService = new SessionService(); // Add this line
    }
    public function getAllRestaurants()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM restaurants");
            $stmt->execute();
            $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($restaurants as &$restaurant) {
                // Adding features
                $features = $this->getFeaturesForRestaurant($restaurant['restaurant_id']);
                $restaurant['features'] = $features;

                // Adding sessions
                $sessions = $this->sessionService->getSessionsByRestaurantId($restaurant['restaurant_id']);
                $restaurant['sessions'] = $sessions;
            }
            unset($restaurant); // break the reference with the last element

            return $restaurants;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}
