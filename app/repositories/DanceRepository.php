<?php
namespace App\Repositories;

use App\Models\Dance;
use Exception;
use PDO;
use PDOException;

class DanceRepository extends Repository
{
    public function getAll()
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT 
                    mp.music_performance_id,
                    mp.music_event_id,
                    me.event_name,
                    me.event_price,
                    me.event_date,
                    me.session_type,
                    me.event_start_time,
                    me.event_duration,
                    me.music_event_image,
                    GROUP_CONCAT(a.artist_name SEPARATOR ', ') AS artist_names,
                    a.genre,
                    a.about,
                    e.event_id,
                    dv.name AS venue_name,
                    dv.location AS venue_location,
                    dv.capacity
                FROM music_performance AS mp
                JOIN music_events AS me ON mp.music_event_id = me.music_event_id
                JOIN artists AS a ON mp.artist_id = a.artist_id
                JOIN events AS e ON me.event_id = e.event_id
                JOIN dance_venues AS dv ON me.venue_id = dv.venue_id
                GROUP BY me.music_event_id
            ");

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getDanceEventById(int $music_performance_id)
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT 
                    mp.music_performance_id,
                    mp.music_event_id,
                    me.event_name,
                    me.event_price,
                    me.event_date,
                    me.session_type,
                    me.event_start_time,
                    me.event_duration,
                    me.music_event_image,
                    GROUP_CONCAT(a.artist_name SEPARATOR ', ') AS artist_names,
                    GROUP_CONCAT(mp.artist_id SEPARATOR ', ') AS artist_id,
                    a.genre,
                    a.about,
                    e.event_id,
                    dv.venue_id,
                    dv.name AS venue_name,
                    dv.location AS venue_location,
                    dv.capacity
                FROM music_performance AS mp
                JOIN music_events AS me ON mp.music_event_id = me.music_event_id
                JOIN artists AS a ON mp.artist_id = a.artist_id
                JOIN events AS e ON me.event_id = e.event_id
                JOIN dance_venues AS dv ON me.venue_id = dv.venue_id
                WHERE mp.music_performance_id = :music_performance_id
                GROUP BY me.music_event_id
            ");

            $stmt->bindParam(':music_performance_id', $music_performance_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getfridayEvents()
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT 
                    mp.music_performance_id,
                    mp.music_event_id,
                    me.event_name,
                    me.event_price,
                    me.event_date,
                    me.session_type,
                    me.event_start_time,
                    me.event_duration,
                    me.music_event_image,
                    GROUP_CONCAT(a.artist_name SEPARATOR ', ') AS artist_names,
                    e.event_id,
                    dv.name AS venue_name
                FROM music_performance AS mp
                JOIN music_events AS me ON mp.music_event_id = me.music_event_id
                JOIN artists AS a ON mp.artist_id = a.artist_id
                JOIN events AS e ON me.event_id = e.event_id
                JOIN dance_venues AS dv ON me.venue_id = dv.venue_id
                WHERE me.event_date = '2024-07-27'
                GROUP BY me.music_event_id
            ");

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getSaturdayEvents()
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT 
                    mp.music_performance_id,
                    mp.music_event_id,
                    me.event_name,
                    me.event_price,
                    me.event_date,
                    me.session_type,
                    me.event_start_time,
                    me.event_duration,
                    me.music_event_image,
                    GROUP_CONCAT(a.artist_name SEPARATOR ', ') AS artist_names,
                    e.event_id,
                    dv.name AS venue_name
                FROM music_performance AS mp
                JOIN music_events AS me ON mp.music_event_id = me.music_event_id
                JOIN artists AS a ON mp.artist_id = a.artist_id
                JOIN events AS e ON me.event_id = e.event_id
                JOIN dance_venues AS dv ON me.venue_id = dv.venue_id
                WHERE me.event_date = '2024-07-28'
                GROUP BY me.music_event_id
            ");

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getSundayEvents()
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT 
                    mp.music_performance_id,
                    mp.music_event_id,
                    me.event_name,
                    me.event_price,
                    me.event_date,
                    me.session_type,
                    me.event_start_time,
                    me.event_duration,
                    me.music_event_image,
                    GROUP_CONCAT(a.artist_name SEPARATOR ', ') AS artist_names,
                    e.event_id,
                    dv.name AS venue_name
                FROM music_performance AS mp
                JOIN music_events AS me ON mp.music_event_id = me.music_event_id
                JOIN artists AS a ON mp.artist_id = a.artist_id
                JOIN events AS e ON me.event_id = e.event_id
                JOIN dance_venues AS dv ON me.venue_id = dv.venue_id
                WHERE me.event_date = '2024-07-29'
                GROUP BY me.music_event_id
            ");

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getEventsByArtistId(int $artistId)
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT 
                    mp.music_performance_id,
                    mp.music_event_id,
                    me.event_price,
                    me.event_date,
                    me.event_start_time,
                    me.venue_id,
                    dv.name AS venue_name
                FROM music_performance AS mp
                JOIN music_events AS me ON mp.music_event_id = me.music_event_id
                JOIN dance_venues AS dv ON me.venue_id = dv.venue_id
                WHERE mp.artist_id = :artist_id
            ");

            $stmt->bindParam(':artist_id', $artistId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getArtistIdsByEventId(int $music_event_id)
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT artist_id
                FROM music_performance
                WHERE music_event_id = :music_event_id
            ");

            $stmt->bindParam(':music_event_id', $music_event_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function update(Dance $dance, $dance_id): bool
    {
        try {
            $stmt = $this->connection->prepare("
                UPDATE dances
                SET dance_name = :dance_name, description = :description, image_url = :image_url
                WHERE dance_id = :dance_id
            ");

            $stmt->execute([
                ':dance_id' => $dance_id,
                ':dance_name' => $dance->getDance_name(),
                ':description' => $dance->getDescription(),
                ':image_url' => $dance->getImage_url()
            ]);

            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function storeDance(Dance $dance)
    {
        try {
            $stmt = $this->connection->prepare("
                INSERT INTO dances (dance_name, description, image_url)
                VALUES (:dance_name, :description, :image_url)
            ");

            $stmt->execute([
                ':dance_name' => $dance->getDance_name(),
                ':description' => $dance->getDescription(),
                ':image_url' => $dance->getImage_url()
            ]);

            return true;
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function deleteDance($dance_id)
    {
        try {
            $stmt = $this->connection->prepare("DELETE FROM dances WHERE dance_id = :dance_id");
            $stmt->bindParam(':dance_id', $dance_id, PDO::PARAM_INT);
            return $stmt->execute();
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getAllPasses()
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM ticket_pass");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function getPassDetailsByType(string $passType)
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT pass_id, passName, passDescription, passPrice, passType
                FROM ticket_pass
                WHERE passType = :passType
            ");

            $stmt->bindParam(':passType', $passType, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error: " . $e->getMessage());
        }
    }
}