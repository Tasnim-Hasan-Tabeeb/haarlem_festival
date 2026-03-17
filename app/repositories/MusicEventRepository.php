<?php

namespace App\Repositories;

use Exception;
use PDO;
use PDOException;

class MusicEventRepository extends Repository
{
    public function getAllForManagement(): array
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT
                    me.music_event_id,
                    me.event_name,
                    me.event_date,
                    me.event_start_time,
                    me.event_price,
                    me.event_duration,
                    me.session_type,
                    me.music_event_image,
                    dv.name AS venue_name,
                    a.artist_name AS artist_names
                FROM music_events me
                LEFT JOIN dance_venues dv ON me.venue_id = dv.venue_id
                LEFT JOIN artists a ON me.artist_id = a.artist_id
                ORDER BY me.event_date ASC, me.event_start_time ASC
            ");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching music events for management: " . $e->getMessage());
        }
    }

    public function getAll(): array
    {
        try {
            $stmt = $this->connection->prepare("SELECT * FROM music_events");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            throw new Exception("Error fetching all music events: " . $e->getMessage());
        }
    }

    public function create(array $data): int
    {
        try {
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
                ':event_id'         => $data['event_id'],
                ':artist_id'        => $data['artist_id'],
                ':venue_id'         => $data['venue_id'],
                ':event_date'       => $data['event_date'],
                ':event_name'       => $data['event_name'],
                ':event_price'      => $data['event_price'],
                ':session_type'     => $data['session_type'],
                ':event_start_time' => $data['event_start_time'],
                ':event_duration'   => $data['event_duration'],
                ':music_event_image'=> $data['music_event_image'],
            ]);

            return (int)$this->connection->lastInsertId();
        } catch (PDOException $e) {
            throw new Exception("Error creating music event: " . $e->getMessage());
        }
    }

    public function getById(int $musicEventId): array
    {
        try {
            $stmt = $this->connection->prepare("
                SELECT *
                FROM music_events
                WHERE music_event_id = :music_event_id
                LIMIT 1
            ");
            $stmt->bindParam(':music_event_id', $musicEventId, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            return $row ?: [];
        } catch (PDOException $e) {
            throw new Exception("Error fetching music event: " . $e->getMessage());
        }
    }

    public function update(int $musicEventId, array $data): bool
    {
        try {
            $stmt = $this->connection->prepare("
                UPDATE music_events
                SET
                    artist_id = :artist_id,
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
                ':music_event_id'    => $musicEventId,
                ':artist_id'         => $data['artist_id'],
                ':venue_id'          => $data['venue_id'],
                ':event_date'        => $data['event_date'],
                ':event_name'        => $data['event_name'],
                ':event_price'       => $data['event_price'],
                ':session_type'      => $data['session_type'],
                ':event_start_time'  => $data['event_start_time'],
                ':event_duration'    => $data['event_duration'],
                ':music_event_image' => $data['music_event_image'],
            ]);

            return true;
        } catch (PDOException $e) {
            throw new Exception("Error updating music event: " . $e->getMessage());
        }
    }

    public function delete(int $musicEventId): bool
    {
        try {
            $this->connection->beginTransaction();

            $performanceStmt = $this->connection->prepare("
                DELETE FROM music_performance
                WHERE music_event_id = :music_event_id
            ");
            $performanceStmt->bindParam(':music_event_id', $musicEventId, PDO::PARAM_INT);
            $performanceStmt->execute();

            $eventStmt = $this->connection->prepare("
                DELETE FROM music_events
                WHERE music_event_id = :music_event_id
            ");
            $eventStmt->bindParam(':music_event_id', $musicEventId, PDO::PARAM_INT);
            $eventStmt->execute();

            $this->connection->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->connection->inTransaction()) {
                $this->connection->rollBack();
            }

            throw new Exception("Error deleting music event: " . $e->getMessage());
        }
    }

}

