<?php

namespace App\Repositories;

use App\Models\Events;
use Exception;
use PDO;
use PDOException;

class EventRepository extends Repository{

    public function getAll()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM events");
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $events;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getEventById(int $event_id)
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM events WHERE  event_id = :event_id");
            $stmt->bindParam(':event_id', $event_id);
            $stmt->execute();
            $events = $stmt->fetch(PDO::FETCH_ASSOC);
            return $events;
            return null;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
    public function storeEvent(Events $event)
    {
        try {
            $stmt = $this->connection->prepare("INSERT INTO events (event_type, title, image_url, description, status, start_date, end_date, primary_theme_color, secondary_theme_color) VALUES (:event_type, :title, :image_url, :description, :status, :start_date, :end_date, :primary_theme_color, :secondary_theme_color)");
            $stmt->execute([
                ':event_type' => $event->getEventType(),
                ':title' => $event->getEventTitle(),
                ':image_url' => $event->getEventImage(),
                ':description' => $event->getEventDescription(),
                ':status' => 1, 
                ':start_date' => $event->getEventStartDate(),
                ':end_date' => $event->getEventEndDate(),
                ':primary_theme_color' => $event->getPrimaryThemeColor(),
                ':secondary_theme_color' => $event->getSecondaryThemeColor(),
            ]);
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }


    public function updateEvent(Events $event, $event_id)
    {
        try {

            $stmt = $this->connection->prepare("UPDATE events SET event_type = :event_type, title = :title,  image_url = :image_url, description = :description, status = :status,  start_date = :start_date, end_date = :end_date, primary_theme_color = :primary_theme_color, secondary_theme_color = :secondary_theme_color WHERE event_id = :event_id");
            $stmt->execute([
                ':event_id' => $event_id,
                ':event_type' => $event->getEventType(),
                ':title' => $event->getEventTitle(),
                ':image_url' => $event->getEventImage(),
                ':description' => $event->getEventDescription(),
                ':status' => $event->getEventStatus(),
                ':start_date' => $event->getEventStartDate(),
                ':end_date' => $event->getEventEndDate(),
                ':primary_theme_color' => $event->getPrimaryThemeColor(),
                ':secondary_theme_color' => $event->getSecondaryThemeColor(),
            ]);

            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }


    public function deleteEvent($event_id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM events WHERE event_id = :event_id");
            $stmt->bindParam(':event_id', $event_id);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getEventByArtist($artistID)
    {
        try {
            $stmt = $this->connection->prepare("SELECT mua FROM music_perfromance WHERE event_type = :event_type");
            $stmt->bindParam(':event_type', $event_type);
            $stmt->execute();
            $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $events;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

}