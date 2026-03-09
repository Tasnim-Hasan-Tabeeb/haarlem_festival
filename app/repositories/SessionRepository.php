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
                    s.session_id,
                    s.restaurant_id,
                    s.event_id,
                    s.start_time,
                    s.duration,
                    s.sessions_per_day,
                    s.total_session,
                    s.first_session,
                    r.title AS restaurant_title,
                    e.title AS event_title
                FROM sessions s
                INNER JOIN restaurants r ON s.restaurant_id = r.restaurant_id
                LEFT JOIN events e ON s.event_id = e.event_id
                ORDER BY s.session_id DESC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getSessionsByRestaurantId($restaurantId)
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT *
                FROM sessions
                WHERE restaurant_id = :restaurant_id
            ");
            $stmt->bindParam(':restaurant_id', $restaurantId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getAllEvents()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM events ORDER BY event_id DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    private function getEventIdByRestaurantId(int $restaurantId): int
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT event_id
                FROM restaurants
                WHERE restaurant_id = :restaurant_id
                LIMIT 1
            ");
            $stmt->bindParam(':restaurant_id', $restaurantId, PDO::PARAM_INT);
            $stmt->execute();

            $eventId = $stmt->fetchColumn();

            if (!$eventId) {
                throw new Exception("Selected restaurant has no linked event_id.");
            }

            return (int) $eventId;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function createSession(Session $session)
    {
        try {
            $restaurantId = (int) $session->getRestaurantId();
            $eventId = $this->getEventIdByRestaurantId($restaurantId);

            $stmt = $this->connection->prepare("
                INSERT INTO sessions (
                    restaurant_id,
                    event_id,
                    start_time,
                    duration,
                    sessions_per_day,
                    total_session,
                    first_session
                )
                VALUES (
                    :restaurant_id,
                    :event_id,
                    :start_time,
                    :duration,
                    :sessions_per_day,
                    :total_session,
                    :first_session
                )
            ");

            $stmt->execute([
                ':restaurant_id'    => $restaurantId,
                ':event_id'         => $eventId,
                ':start_time'       => $session->getStartTime(),
                ':duration'         => $session->getDuration(),
                ':sessions_per_day' => (int) $session->getSessionsPerDay(),
                ':total_session'    => (int) $session->getSessionsPerDay(),
                ':first_session'    => $session->getStartTime(),
            ]);

            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getSession($session_id)
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT *
                FROM sessions
                WHERE session_id = :session_id
            ");
            $stmt->bindParam(':session_id', $session_id, PDO::PARAM_INT);
            $stmt->execute();

            $sessionRow = $stmt->fetch(PDO::FETCH_ASSOC);
            return $sessionRow ?: null;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function updateSession(Session $session)
    {
        try {
            $restaurantId = (int) $session->getRestaurantId();
            $eventId = $this->getEventIdByRestaurantId($restaurantId);

            $stmt = $this->connection->prepare("
                UPDATE sessions
                SET 
                    restaurant_id = :restaurant_id,
                    event_id = :event_id,
                    start_time = :start_time,
                    duration = :duration,
                    sessions_per_day = :sessions_per_day,
                    total_session = :total_session,
                    first_session = :first_session
                WHERE session_id = :session_id
            ");

            $stmt->execute([
                ':session_id'       => (int) $session->getSessionId(),
                ':restaurant_id'    => $restaurantId,
                ':event_id'         => $eventId,
                ':start_time'       => $session->getStartTime(),
                ':duration'         => $session->getDuration(),
                ':sessions_per_day' => (int) $session->getSessionsPerDay(),
                ':total_session'    => (int) $session->getSessionsPerDay(),
                ':first_session'    => $session->getStartTime(),
            ]);

            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function deleteSession($session_id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM sessions WHERE session_id = :session_id");
            $stmt->bindParam(':session_id', $session_id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}