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

    public function getFeaturesForRestaurant(int $restaurantId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT *
                                                FROM restaurant_features rf 
                                                JOIN features f ON rf.feature_id = f.feature_id 
                                                WHERE rf.restaurant_id = :restaurant_id");
            $stmt->execute(['restaurant_id' => $restaurantId]);
            $features = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $features;
        } catch (PDOException $e) {
            throw new Exception("Error fetching features for restaurant $restaurantId: " . $e->getMessage());
        }
    }

    public function createRestaurant(Restaurant $restaurant)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO restaurants (title, image_url, description, ratings, cuisines, event_id, location, number_of_seats, contact_email, contact_phone, gallery_images) VALUES (:title, :image_url, :description, :ratings, :cuisines, :event_id, :location, :number_of_seats, :contact_email, :contact_phone, :gallery_image_url)");
            $stmt->execute([
                ':title' => $restaurant->getTitle(),
                ':image_url' => $restaurant->getImageUrl(),
                ':description' => $restaurant->getDescription(),
                ':ratings' => $restaurant->getRatings(),
                ':cuisines' => $restaurant->getCuisines(),
                ':event_id' => $restaurant->getEventId(),
                ':location' => $restaurant->getLocation(),
                ':number_of_seats' => $restaurant->getNumberOfSeats(),
                ':contact_email' => $restaurant->getContactEmail(),
                ':contact_phone' => $restaurant->getContactPhone(),
                ':gallery_image_url' => $restaurant->getGalleryImages(),
            ]);
            $restaurantId = $this->connection->lastInsertId();
            return $restaurantId;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function associateFeaturesWithRestaurant(int $restaurantId, array $featureIds)
    {
        try {
            foreach ($featureIds as $featureId) {
                $stmt = $this->connection->prepare("INSERT INTO restaurant_features (restaurant_id, feature_id) VALUES (:restaurant_id, :feature_id)");
                $stmt->execute([
                    ':restaurant_id' => $restaurantId,
                    ':feature_id' => $featureId,
                ]);
            }
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getRestaurant($restaurantId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * 
                                                FROM restaurants
                                                WHERE restaurant_id = :restaurant_id");
            $stmt->bindParam(':restaurant_id', $restaurantId);
            $stmt->execute();
            $restaurantRow = $stmt->fetch(PDO::FETCH_ASSOC);

            $features = $this->getFeaturesForRestaurant($restaurantId);
            $restaurantRow['features'] = $features;

            if ($stmt->rowCount() > 0) {
                return $restaurantRow;
            }
            return null;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function updateRestaurant(Restaurant $restaurant)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE restaurants SET title = :title, image_url = :image_url, description = :description, ratings = :ratings, cuisines = :cuisines, event_id = :event_id, location = :location, number_of_seats = :number_of_seats, contact_email = :contact_email, contact_phone = :contact_phone, gallery_images = :gallery_image_url WHERE restaurant_id = :restaurant_id");
            $stmt->execute([
                ':restaurant_id' => $restaurant->getRestaurantId(),
                ':title' => $restaurant->getTitle(),
                ':image_url' => $restaurant->getImageUrl(),
                ':description' => $restaurant->getDescription(),
                ':ratings' => $restaurant->getRatings(),
                ':cuisines' => $restaurant->getCuisines(),
                ':event_id' => $restaurant->getEventId(),
                ':location' => $restaurant->getLocation(),
                ':number_of_seats' => $restaurant->getNumberOfSeats(),
                ':contact_email' => $restaurant->getContactEmail(),
                ':contact_phone' => $restaurant->getContactPhone(),
                ':gallery_image_url' => $restaurant->getGalleryImages(),
            ]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function deleteRestaurant($restaurantId)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM restaurants WHERE restaurant_id = :restaurant_id");
            $stmt->bindParam(':restaurant_id', $restaurantId);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}
