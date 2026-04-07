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

    public function updateManagedEvent(
        int $musicPerformanceId,
        string $eventName,
        string $eventDate,
        string $eventStartTime,
        float $eventPrice,
        int $eventDuration,
        string $sessionType,
        int $venueId,
        array $artistIds,
        ?string $musicEventImage = null
    ): bool {
        try {
            $existingEvent = $this->getDanceEventById($musicPerformanceId);

            if (!$existingEvent) {
                throw new Exception("Dance event not found.");
            }

            $musicEventId = (int)$existingEvent['music_event_id'];
            $eventId = (int)$existingEvent['event_id'];
            $currentImage = $existingEvent['music_event_image'] ?? null;
            $artistIds = array_values(array_unique(array_map('intval', $artistIds)));

            if (empty($artistIds)) {
                $artistIds = array_map('intval', explode(',', (string)($existingEvent['artist_id'] ?? '')));
                $artistIds = array_values(array_filter($artistIds));
            }

            if (empty($artistIds)) {
                throw new Exception("At least one artist must be selected.");
            }

            $imageToStore = $musicEventImage ?? $currentImage;

            $stmt = $this->connection->prepare("
                SELECT music_performance_id, artist_id, quantity
                FROM music_performance
                WHERE music_event_id = :music_event_id
            ");
            $stmt->bindParam(':music_event_id', $musicEventId, PDO::PARAM_INT);
            $stmt->execute();
            $existingPerformances = $stmt->fetchAll(PDO::FETCH_ASSOC);

            $performancesByArtist = [];
            $defaultQuantity = 1;

            foreach ($existingPerformances as $performance) {
                $performancesByArtist[(int)$performance['artist_id']] = $performance;
                $defaultQuantity = (int)$performance['quantity'];
            }

            $this->connection->beginTransaction();

            $stmt = $this->connection->prepare("
                UPDATE music_events
                SET artist_id = :artist_id,
                    venue_id = :venue_id,
                    event_date = :event_date,
                    event_name = :event_name,
                    event_price = :event_price,
                    session_type = :session_type,
                    event_start_time = :event_start_time,
                    event_duration = :event_duration,
                    music_event_image = :music_event_image
                WHERE music_event_id = :music_event_id
            ");
            $stmt->execute([
                ':artist_id' => $artistIds[0],
                ':venue_id' => $venueId,
                ':event_date' => $eventDate,
                ':event_name' => $eventName,
                ':event_price' => $eventPrice,
                ':session_type' => $sessionType,
                ':event_start_time' => $eventStartTime,
                ':event_duration' => $eventDuration,
                ':music_event_image' => $imageToStore,
                ':music_event_id' => $musicEventId,
            ]);

            foreach ($artistIds as $artistId) {
                if (isset($performancesByArtist[$artistId])) {
                    $stmt = $this->connection->prepare("
                        UPDATE music_performance
                        SET artist_id = :artist_id,
                            title = :title,
                            session_type = :session_type,
                            start_date = :start_date,
                            event_start_time = :event_start_time,
                            event_duration = :event_duration,
                            event_price = :event_price
                        WHERE music_performance_id = :music_performance_id
                    ");
                    $stmt->execute([
                        ':artist_id' => $artistId,
                        ':title' => $eventName,
                        ':session_type' => $sessionType,
                        ':start_date' => $eventDate,
                        ':event_start_time' => $eventStartTime,
                        ':event_duration' => $eventDuration,
                        ':event_price' => $eventPrice,
                        ':music_performance_id' => $performancesByArtist[$artistId]['music_performance_id'],
                    ]);
                    continue;
                }

                $stmt = $this->connection->prepare("
                    INSERT INTO music_performance (
                        music_event_id,
                        artist_id,
                        event_id,
                        title,
                        session_type,
                        start_date,
                        event_start_time,
                        event_duration,
                        event_price,
                        quantity
                    ) VALUES (
                        :music_event_id,
                        :artist_id,
                        :event_id,
                        :title,
                        :session_type,
                        :start_date,
                        :event_start_time,
                        :event_duration,
                        :event_price,
                        :quantity
                    )
                ");
                $stmt->execute([
                    ':music_event_id' => $musicEventId,
                    ':artist_id' => $artistId,
                    ':event_id' => $eventId,
                    ':title' => $eventName,
                    ':session_type' => $sessionType,
                    ':start_date' => $eventDate,
                    ':event_start_time' => $eventStartTime,
                    ':event_duration' => $eventDuration,
                    ':event_price' => $eventPrice,
                    ':quantity' => $defaultQuantity,
                ]);
            }

            $placeholders = implode(',', array_fill(0, count($artistIds), '?'));
            $params = array_merge([$musicEventId], $artistIds);
            $stmt = $this->connection->prepare("
                DELETE FROM music_performance
                WHERE music_event_id = ?
                  AND artist_id NOT IN ($placeholders)
            ");
            $stmt->execute($params);

            $this->connection->commit();
            return true;
        } catch (Exception $e) {
            if ($this->connection->inTransaction()) {
                $this->connection->rollBack();
            }
            throw new Exception("Error: " . $e->getMessage());
        }
    }

    public function createManagedEvent(
        string $eventName,
        string $eventDate,
        string $eventStartTime,
        float $eventPrice,
        int $eventDuration,
        string $sessionType,
        int $venueId,
        array $artistIds,
        ?string $musicEventImage = null
    ): int {
        try {
            $artistIds = array_values(array_unique(array_map('intval', $artistIds)));
            if (empty($artistIds)) {
                throw new Exception("At least one artist must be selected.");
            }

            $stmt = $this->connection->prepare("
                SELECT event_id
                FROM events
                WHERE event_type = 'Dance'
                ORDER BY event_id ASC
                LIMIT 1
            ");
            $stmt->execute();
            $danceEventId = (int)$stmt->fetchColumn();

            if ($danceEventId <= 0) {
                throw new Exception("Dance parent event not found.");
            }

            $this->connection->beginTransaction();

            $stmt = $this->connection->prepare("
                INSERT INTO music_events (
                    event_id,
                    artist_id,
                    venue_id,
                    event_date,
                    event_name,
                    event_price,
                    session_type,
                    event_start_time,
                    event_duration,
                    music_event_image
                ) VALUES (
                    :event_id,
                    :artist_id,
                    :venue_id,
                    :event_date,
                    :event_name,
                    :event_price,
                    :session_type,
                    :event_start_time,
                    :event_duration,
                    :music_event_image
                )
            ");
            $stmt->execute([
                ':event_id' => $danceEventId,
                ':artist_id' => $artistIds[0],
                ':venue_id' => $venueId,
                ':event_date' => $eventDate,
                ':event_name' => $eventName,
                ':event_price' => $eventPrice,
                ':session_type' => $sessionType,
                ':event_start_time' => $eventStartTime,
                ':event_duration' => $eventDuration,
                ':music_event_image' => $musicEventImage,
            ]);

            $musicEventId = (int)$this->connection->lastInsertId();

            $stmt = $this->connection->prepare("
                INSERT INTO music_performance (
                    music_event_id,
                    artist_id,
                    event_id,
                    title,
                    session_type,
                    start_date,
                    event_start_time,
                    event_duration,
                    event_price,
                    quantity
                ) VALUES (
                    :music_event_id,
                    :artist_id,
                    :event_id,
                    :title,
                    :session_type,
                    :start_date,
                    :event_start_time,
                    :event_duration,
                    :event_price,
                    :quantity
                )
            ");

            foreach ($artistIds as $artistId) {
                $stmt->execute([
                    ':music_event_id' => $musicEventId,
                    ':artist_id' => $artistId,
                    ':event_id' => $danceEventId,
                    ':title' => $eventName,
                    ':session_type' => $sessionType,
                    ':start_date' => $eventDate,
                    ':event_start_time' => $eventStartTime,
                    ':event_duration' => $eventDuration,
                    ':event_price' => $eventPrice,
                    ':quantity' => 1,
                ]);
            }

            $this->connection->commit();

            return $musicEventId;
        } catch (Exception $e) {
            if ($this->connection->inTransaction()) {
                $this->connection->rollBack();
            }
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
