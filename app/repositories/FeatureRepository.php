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
        $stmt = $this->connection->prepare('SELECT * FROM features');
        $stmt->execute();
        $features = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $features;
    }

    public function getAllFeaturesByRestaurantId(mixed $restaurantId)
    {
        $stmt = $this->connection->prepare('SELECT * FROM restaurant_features WHERE restaurant_id = :restaurant_id');
        $stmt->bindParam(':restaurant_id', $restaurantId);
        $stmt->execute();
        $features = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $features;
    }

    public function createFeature(Feature $feature)
    {
        $stmt = $this->connection->prepare('INSERT INTO features (image_url, name) VALUES (:image_url, :name)');
        $stmt->execute([
            ':image_url' => $feature->getImageUrl(),
            ':name'      => $feature->getName()
        ]);
        return true;
    }

    /**
     * Summary of getFeature
     * @param mixed $feature_id
     * @throws Exception
     */
    public function getFeature($feature_id)
    {
        $stmt = $this->connection->prepare('SELECT * FROM features WHERE feature_id = :feature_id');
        $stmt->bindParam(':feature_id', $feature_id);
        $stmt->execute();
        $featureRow = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($stmt->rowCount() > 0) {
            return $featureRow;
        }
        return null;
    }

    public function updateFeature(Feature $feature)
    {
        $stmt = $this->connection->prepare('UPDATE features SET image_url = :image_url, name = :name WHERE feature_id = :feature_id');
        $stmt->execute([
            ':image_url'  => $feature->getImageUrl(),
            ':name'       => $feature->getName(),
            ':feature_id' => $feature->getFeatureId()
        ]);
        return true;
    }

    /**
     * Summary of deleteFeature
     * @param mixed $feature_id
     * @throws Exception
     * @return bool
     */
    public function deleteFeature($feature_id)
    {
        $stmt = $this->connection->prepare('DELETE FROM features WHERE feature_id = :feature_id');
        $stmt->bindParam(':feature_id', $feature_id);
        $stmt->execute();
        return true;
    }

    public function deleteFeatureByRestaurantId(mixed $restaurantId)
    {
        $stmt = $this->connection->prepare('DELETE FROM restaurant_features WHERE restaurant_id = :restaurant_id');
        $stmt->bindParam(':restaurant_id', $restaurantId);
        $stmt->execute();
        return true;
    }
}
