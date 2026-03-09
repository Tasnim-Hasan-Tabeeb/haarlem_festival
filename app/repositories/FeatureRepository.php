<?php

namespace App\Repositories;

use App\Models\Feature;
use Exception;
use PDO;
use PDOException;

class FeatureRepository extends Repository
{

    public function getAllFeatures()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM features");
            $stmt->execute();
            $features = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $features;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    
    public function getAllFeaturesByRestaurantId($restaurantId)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM restaurant_features WHERE restaurant_id = :restaurant_id");
            $stmt->bindParam(':restaurant_id', $restaurantId);
            $stmt->execute();
            $features = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $features;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function createFeature(Feature $feature)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO features (image_url, name) VALUES (:image_url, :name)");
            $stmt->execute([
                ':image_url' => $feature->getImageUrl(),
                ':name' => $feature->getName()
            ]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getFeature($feature_id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM features WHERE feature_id = :feature_id");
            $stmt->bindParam(':feature_id', $feature_id);
            $stmt->execute();
            $featureRow = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($stmt->rowCount() > 0) {
                return $featureRow;
            }
            return null;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function updateFeature(Feature $feature)
    {
        try {
            $stmt = $this->connection->prepare("UPDATE features SET image_url = :image_url, name = :name WHERE feature_id = :feature_id");
            $stmt->execute([
                ':image_url' => $feature->getImageUrl(),
                ':name' => $feature->getName(),
                ':feature_id' => $feature->getFeatureId()
            ]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function deleteFeature($feature_id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM features WHERE feature_id = :feature_id");
            $stmt->bindParam(':feature_id', $feature_id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function deleteFeatureByRestaurantId($restaurantId)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM restaurant_features WHERE restaurant_id = :restaurant_id");
            $stmt->bindParam(':restaurant_id', $restaurantId);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
}
