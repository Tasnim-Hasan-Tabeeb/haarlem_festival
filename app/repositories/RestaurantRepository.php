<?php

namespace App\Repositories;

use App\Models\Restaurant;
use Exception;
use PDO;
use PDOException;

class RestaurantRepository extends Repository
{
    public function __construct()
    {
        parent::__construct();
    }
    public function getAllRestaurants()
    {
        $stmt = $this->connection->prepare('SELECT * FROM restaurants');
        $stmt->execute();
        $restaurants = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($restaurants as &$restaurant) {
            $features               = $this->getFeaturesForRestaurant($restaurant['restaurant_id']);
            $restaurant['features'] = $features;
            $sessions               = $this->getSessionsByRestaurantId($restaurant['restaurant_id']);
            $restaurant['sessions'] = $sessions;
        }
        unset($restaurant); // break the reference with the last element

        return $restaurants;
    }

    /**
     * Summary of getSessionsByRestaurantId
     * @param mixed $restaurantId
     * @throws Exception
     * @return array
     */
    public function getSessionsByRestaurantId($restaurantId)
    {
        $stmt = $this->connection->prepare('
            SELECT *
            FROM sessions
            WHERE restaurant_id = :restaurant_id
        ');
        $stmt->bindParam(':restaurant_id', $restaurantId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFeaturesForRestaurant(int $restaurantId)
    {
        $stmt = $this->connection->prepare('SELECT *
                                            FROM restaurant_features rf 
                                            JOIN features f ON rf.feature_id = f.feature_id 
                                            WHERE rf.restaurant_id = :restaurant_id');
        $stmt->execute(['restaurant_id' => $restaurantId]);
        $features = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $features;
    }

    public function createRestaurant(Restaurant $restaurant)
    {
        $stmt = $this->connection->prepare(
            'INSERT INTO restaurants 
            (title, image_url, description, ratings, cuisines, event_id, location, number_of_seats, contact_email, contact_phone, gallery_images , price_for_child, price_for_adult) VALUES (:title, :image_url, :description, :ratings, :cuisines, :event_id, :location, :number_of_seats, :contact_email, :contact_phone, :gallery_image_url , :price_for_child, :price_for_adult)'
        );
        $stmt->execute([
            ':title'             => $restaurant->getTitle(),
            ':image_url'         => $restaurant->getImageUrl(),
            ':description'       => $restaurant->getDescription(),
            ':ratings'           => $restaurant->getRatings(),
            ':cuisines'          => $restaurant->getCuisines(),
            ':event_id'          => $restaurant->getEventId(),
            ':location'          => $restaurant->getLocation(),
            ':number_of_seats'   => $restaurant->getNumberOfSeats(),
            ':contact_email'     => $restaurant->getContactEmail(),
            ':contact_phone'     => $restaurant->getContactPhone(),
            ':gallery_image_url' => $restaurant->getGalleryImages(),
            ':price_for_child'   => $restaurant->getPriceForChild(),
            ':price_for_adult'   => $restaurant->getPriceForAdult(),
        ]);
        $restaurantId = $this->connection->lastInsertId();
        return $restaurantId;
    }

    public function associateFeaturesWithRestaurant(int $restaurantId, array $featureIds)
    {
        foreach ($featureIds as $featureId) {
            $stmt = $this->connection->prepare('INSERT INTO restaurant_features (restaurant_id, feature_id) VALUES (:restaurant_id, :feature_id)');
            $stmt->execute([
                ':restaurant_id' => $restaurantId,
                ':feature_id'    => $featureId,
            ]);
        }
        return true;
    }

    /**
     * Summary of getRestaurant
     * @param mixed $restaurantId
     * @throws Exception
     */
    public function getRestaurant($restaurantId)
    {
        $stmt = $this->connection->prepare('SELECT * 
                                            FROM restaurants
                                            WHERE restaurant_id = :restaurant_id');
        $stmt->bindParam(':restaurant_id', $restaurantId);
        $stmt->execute();
        $restaurantRow = $stmt->fetch(PDO::FETCH_ASSOC);

        $features                  = $this->getFeaturesForRestaurant($restaurantId);
        $restaurantRow['features'] = $features;

        if ($stmt->rowCount() > 0) {
            return $restaurantRow;
        }
        return null;
    }

    public function updateRestaurant(Restaurant $restaurant)
    {
        $stmt = $this->connection->prepare('UPDATE restaurants SET title = :title, image_url = :image_url, description = :description, ratings = :ratings, cuisines = :cuisines, event_id = :event_id, location = :location, number_of_seats = :number_of_seats,  contact_email = :contact_email, contact_phone = :contact_phone, gallery_images = :gallery_image_url, price_for_child = :price_for_child, price_for_adult = :price_for_adult WHERE restaurant_id = :restaurant_id');
        $stmt->execute([
            ':restaurant_id'     => $restaurant->getRestaurantId(),
            ':title'             => $restaurant->getTitle(),
            ':image_url'         => $restaurant->getImageUrl(),
            ':description'       => $restaurant->getDescription(),
            ':ratings'           => $restaurant->getRatings(),
            ':cuisines'          => $restaurant->getCuisines(),
            ':event_id'          => $restaurant->getEventId(),
            ':location'          => $restaurant->getLocation(),
            ':number_of_seats'   => $restaurant->getNumberOfSeats(),
            ':contact_email'     => $restaurant->getContactEmail(),
            ':contact_phone'     => $restaurant->getContactPhone(),
            ':gallery_image_url' => $restaurant->getGalleryImages(),
            ':price_for_child'   => $restaurant->getPriceForChild(),
            ':price_for_adult'   => $restaurant->getPriceForAdult(),
        ]);
        return true;
    }

    /**
     * Summary of deleteRestaurant
     * @param mixed $restaurantId
     * @throws Exception
     * @return bool
     */
    public function deleteRestaurant($restaurantId)
    {
        $stmt = $this->connection->prepare('DELETE FROM restaurants WHERE restaurant_id = :restaurant_id');
        $stmt->bindParam(':restaurant_id', $restaurantId);
        $stmt->execute();
        return true;
    }
}
