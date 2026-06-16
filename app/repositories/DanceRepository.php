<?php

namespace App\Repositories;

use App\Models\Dance;
use Exception;
use PDO;
use PDOException;

class DanceRepository extends Repository
{
    /**
     * CENTRAL BASE QUERY
     * Reusable SELECT with joins
     */
    private function baseEventQuery(): string
    {
        return "
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
                GROUP_CONCAT(DISTINCT a.artist_name SEPARATOR ', ') AS artist_names,
                GROUP_CONCAT(DISTINCT mp.artist_id) AS artist_ids,
                a.genre,
                a.about,
                e.event_id,
                dv.venue_id,
                dv.name AS venue_name,
                dv.location AS venue_location,
                dv.capacity
            FROM music_performance mp
            JOIN music_events me ON mp.music_event_id = me.music_event_id
            JOIN artists a ON mp.artist_id = a.artist_id
            JOIN events e ON me.event_id = e.event_id
            JOIN dance_venues dv ON me.venue_id = dv.venue_id
        ";
    }

    /**
     * Get ALL events
     */
    public function getAll()
    {
        try {
            $sql = $this->baseEventQuery() . '
                GROUP BY mp.music_event_id
            ';

            $stmt = $this->connection->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Get single event by performance id
     */
    public function getDanceEventById(int $id)
    {
        try {
            $sql = $this->baseEventQuery() . '
                WHERE mp.music_performance_id = :id
                GROUP BY mp.music_event_id
            ';

            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Get events by date (REPLACES friday/saturday/sunday duplicates)
     */
    public function getEventsByDate(string $date)
    {
        try {
            $sql = $this->baseEventQuery() . '
                WHERE me.event_date = :event_date
                GROUP BY mp.music_event_id
                ORDER BY me.event_start_time ASC
            ';

            $stmt = $this->connection->prepare($sql);
            $stmt->bindParam(':event_date', $date);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Summary of getActiveEvents
     * @throws Exception
     * @return array
     */
    public function getActiveEvents()
    {
        try {
            $sql = $this->baseEventQuery() . '
                WHERE me.event_date >= CURDATE()
                GROUP BY mp.music_event_id
                ORDER BY me.event_date ASC, me.event_start_time ASC
            ';

            $stmt = $this->connection->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Artist events
     */
    public function getEventsByArtistId(int $artistId)
    {
        try {
            $stmt = $this->connection->prepare('
                SELECT 
                    mp.music_performance_id,
                    mp.music_event_id,
                    me.event_price,
                    me.event_date,
                    me.event_start_time,
                    me.venue_id,
                    dv.name AS venue_name
                FROM music_performance mp
                JOIN music_events me ON mp.music_event_id = me.music_event_id
                JOIN dance_venues dv ON me.venue_id = dv.venue_id
                WHERE mp.artist_id = :artist_id
                AND me.event_date >= CURDATE()
                
            ');

            $stmt->bindParam(':artist_id', $artistId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * Get artist IDs
     */
    public function getArtistIdsByEventId(int $eventId)
    {
        try {
            $stmt = $this->connection->prepare('
                SELECT artist_id
                FROM music_performance
                WHERE music_event_id = :id
            ');

            $stmt->bindParam(':id', $eventId, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_COLUMN);
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * STORE EVENT
     */
    public function store(Dance $dance, array $artistIds)
    {
        try {
            if (empty($artistIds)) {
                throw new Exception('At least one artist is required');
            }

            $stmt = $this->connection->prepare('
                INSERT INTO music_events
                (
                    event_name,
                    artist_id,
                    event_price,
                    event_date,
                    session_type,
                    event_start_time,
                    event_duration,
                    event_id,
                    venue_id,
                    music_event_image
                )
                VALUES
                (
                    :name,
                    :artist_id,
                    :price,
                    :date,
                    :session,
                    :start_time,
                    :duration,
                    :event_id,
                    :venue_id,
                    :image
                )
            ');

            $stmt->execute([
                ':name'       => $dance->getTitle(),
                ':artist_id'  => $artistIds[0],
                ':price'      => $dance->getEventPrice(),
                ':date'       => $dance->getStartDate(),
                ':session'    => $dance->getSessionType(),
                ':start_time' => $dance->getEventStartTime(),
                ':duration'   => $dance->getEventDuration(),
                ':event_id'   => $dance->getEventId(),
                ':venue_id'   => $dance->getVenueId(),
                ':image'      => $dance->getMusicEventImage(),
            ]);

            $musicEventId = $this->connection->lastInsertId();

            /**
             * 2. INSERT INTO music_performance (MULTIPLE ARTISTS)
             */
            $stmt2 = $this->connection->prepare('
                INSERT INTO music_performance
                (
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
                )
                VALUES
                (
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
            ');

            foreach ($artistIds as $artistId) {
                if (empty($artistId)) {
                    continue;
                }

                $stmt2->execute([
                    ':music_event_id'   => $musicEventId,
                    ':artist_id'        => $artistId,
                    ':event_id'         => $dance->getEventId(),
                    ':title'            => $dance->getTitle(),
                    ':session_type'     => $dance->getSessionType(),
                    ':start_date'       => $dance->getStartDate(),
                    ':event_start_time' => $dance->getEventStartTime(),
                    ':event_duration'   => $dance->getEventDuration(),
                    ':event_price'      => $dance->getEventPrice(),
                    ':quantity'         => $dance->getQuantity(),
                ]);
            }

            return true;
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    /**
     * UPDATE EVENT
     */
    public function update(Dance $dance, array $artistIds)
    {
        try {
            $stmt = $this->connection->prepare('
                UPDATE music_events 
                SET event_name = :name,
                    event_price = :price,
                    event_date = :date,
                    session_type = :session,
                    event_start_time = :start_time,
                    event_duration = :duration,
                    event_id = :event_id,
                    venue_id = :venue_id,
                    music_event_image = :music_event_image
                WHERE music_event_id = :id
            ');

            $stmt->execute([
                ':name'              => $dance->getTitle(),
                ':price'             => $dance->getEventPrice(),
                ':date'              => $dance->getStartDate(),
                ':session'           => $dance->getSessionType(),
                ':start_time'        => $dance->getEventStartTime(),
                ':duration'          => $dance->getEventDuration(),
                ':event_id'          => $dance->getEventId(),
                ':id'                => $dance->getMusicEventId(),
                ':venue_id'          => $dance->getVenueId(),
                ':music_event_image' => $dance->getMusicEventImage()
            ]);

            $this->updateMusicPerformance($dance, $artistIds);

            return true;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function updateMusicPerformance(Dance $dance, array $artistIds)
    {
        try {
            $this->connection->prepare('
                DELETE FROM music_performance 
                WHERE music_event_id = :id
            ')->execute([
                ':id' => $dance->getMusicEventId()
            ]);

            $stmt = $this->connection->prepare('
                INSERT INTO music_performance 
                (
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
                )
                VALUES
                (
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
            ');

            foreach ($artistIds as $artistId) {
                $stmt->execute([
                    ':music_event_id'   => $dance->getMusicEventId(),
                    ':artist_id'        => $artistId,
                    ':event_id'         => $dance->getEventId(),
                    ':title'            => $dance->getTitle(),
                    ':session_type'     => $dance->getSessionType(),
                    ':start_date'       => $dance->getStartDate(),
                    ':event_start_time' => $dance->getEventStartTime(),
                    ':event_duration'   => $dance->getEventDuration(),
                    ':event_price'      => $dance->getEventPrice(),
                    ':quantity'         => $dance->getQuantity(),
                ]);
            }

            return true;
        } catch (PDOException $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function  insertMusicPerformance(Dance $dance, array $artistIds)
    {
    }

    public function getPassDetailsById(int $passId)
    {
        $stmt = $this->connection->prepare('
            SELECT pass_id, passName, passDescription, passPrice, passType, event_date, pass_scope
            FROM ticket_pass
            WHERE pass_id = :pass_id
        ');

        $stmt->bindParam(':pass_id', $passId, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllPasses()
    {
        try {
            $stmt = $this->connection->prepare('SELECT * FROM ticket_pass');
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    public function delete(int $music_performance_id): bool
    {
        try {
            $this->connection->beginTransaction();

            // 1. Get event id first
            $stmt = $this->connection->prepare('
                SELECT music_event_id 
                FROM music_performance 
                WHERE music_performance_id = :id
            ');
            $stmt->execute([':id' => $music_performance_id]);

            $eventId = $stmt->fetchColumn();

            if (!$eventId) {
                throw new Exception('Event not found');
            }

            // 2. Delete artist mapping
            $this->connection->prepare('
                DELETE FROM music_performance 
                WHERE music_event_id = :event_id
            ')->execute([':event_id' => $eventId]);

            // 3. Delete event
            $this->connection->prepare('
                DELETE FROM music_events 
                WHERE music_event_id = :event_id
            ')->execute([':event_id' => $eventId]);

            $this->connection->commit();
            return true;
        } catch (PDOException $e) {
            $this->connection->rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function getMusicEventById(int $music_event_id)
    {
        try {
            $stmt = $this->connection->prepare('SELECT * FROM music_events WHERE music_event_id = :music_event_id');
            $stmt->bindParam(':music_event_id', $music_event_id);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }
}
