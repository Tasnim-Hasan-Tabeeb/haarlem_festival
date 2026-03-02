<?php

namespace App\Repositories;

use App\Models\Session;
use Exception;
use PDO;
use PDOException;

class SessionRepository extends Repository
{
    public function getAllSessions()
    {
        try {
            $stmt = $this->connection->prepare("
            SELECT 
                sessions.session_id, 
                sessions.start_time, 
                sessions.duration, 
                sessions.sessions_per_day, 
                restaurants.title AS restaurant_title
            FROM sessions
            INNER JOIN restaurants ON sessions.restaurant_id = restaurants.restaurant_id
        ");
            $stmt->execute();
            $sessions = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $sessions;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

}

