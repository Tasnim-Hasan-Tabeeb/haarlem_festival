<?php

namespace App\Repositories;

use App\Models\HistoryContent;
use App\Models\location;
use Exception;
use PDO;
use PDOException;

class HistoryRepository extends Repository
{
    public function getAllTourLocations()
    {
        $stmt = $this->connection->prepare('SELECT * FROM tour_locations');
        $stmt->execute();
        $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $history;
    }

    /**
     * Summary of addTour
     * @param mixed $timetable_id
     * @param mixed $language_id
     * @param mixed $available_guides
     * @throws Exception
     * @return bool
     */
    public function addTour($timetable_id, $language_id, $available_guides)
    {
        $stmt = $this->connection->prepare('
            INSERT INTO history_tours (timetable_id, language_id, available_guides)
            VALUES (:timetable_id, :language_id, :available_guides)
        ');

        $stmt->execute([
            ':timetable_id'     => $timetable_id,
            ':language_id'      => $language_id,
            ':available_guides' => $available_guides
        ]);

        return true;
    }

    /**
     * Summary of updateTour
     * @param mixed $id
     * @param mixed $timetable_id
     * @param mixed $language_id
     * @param mixed $available_guides
     * @return bool
     */
    public function updateTour($id, $timetable_id, $language_id, $available_guides)
    {
        $stmt = $this->connection->prepare('
            UPDATE history_tours 
            SET timetable_id = :timetable_id,
                language_id = :language_id,
                available_guides = :available_guides
            WHERE tour_id = :id
        ');

        return $stmt->execute([
            ':timetable_id'     => $timetable_id,
            ':language_id'      => $language_id,
            ':available_guides' => $available_guides,
            ':id'               => $id
        ]);
    }

    public function getAllLanguages()
    {
        $stmt = $this->connection->prepare('SELECT * FROM tour_language');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllTimeSlots()
    {
        $stmt = $this->connection->prepare('SELECT * FROM history_timeslots ORDER BY date, start_time');
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Summary of getTourLocationById
     * @param mixed $id
     * @throws Exception
     */
    public function getTourLocationById($id)
    {
        $stmt = $this->connection->prepare('SELECT * FROM tour_locations WHERE tour_location_id = :id');
        $stmt->execute([':id' => $id]);
        $location = $stmt->fetch(PDO::FETCH_ASSOC);
        return $location;
    }

    public function addLocation(Location $location)
    {
        $stmt = $this->connection->prepare('INSERT INTO tour_locations (location_name, description, address, contact_info, images) VALUES (:location_name, :description, :address, :contact_info, :images)');
        $stmt->execute([
            ':location_name' => $location->getLocation_name(),
            ':description'   => $location->getDescription(),
            ':address'       => $location->getAddress(),
            ':contact_info'  => $location->getContact_info(),
            ':images'        => $location->getImage_url()
        ]);
        return true;
    }

    /**
     * Summary of deleteTour
     * @param mixed $id
     * @return bool
     */
    public function deleteTour($id)
    {
        $stmt = $this->connection->prepare('DELETE FROM history_tours WHERE tour_id = :id');
        return $stmt->execute([':id' => $id]);
    }

    /**
     * Summary of getTourById
     * @param mixed $id
     * @throws Exception
     */
    public function getTourById($id)
    {
        $stmt = $this->connection->prepare('
            SELECT * FROM history_tours WHERE tour_id = :id
        ');
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Summary of updateLocation
     * @param location $location
     * @param mixed $id
     * @throws Exception
     * @return bool
     */
    public function updateLocation(Location $location, $id): bool
    {
        $stmt = $this->connection->prepare('UPDATE tour_locations SET location_name = :location_name, description = :description, address = :address, contact_info = :contact_info, images = :images WHERE tour_location_id = :id');
        $stmt->execute([
            ':location_name' => $location->getLocation_name(),
            ':description'   => $location->getDescription(),
            ':address'       => $location->getAddress(),
            ':contact_info'  => $location->getContact_info(),
            ':images'        => $location->getImage_url(),
            ':id'            => $id
        ]);
        return true;
    }

    /**
     * Summary of deleteLocation
     * @param mixed $id
     * @throws Exception
     * @return bool
     */
    public function deleteLocation($id)
    {
        $stmt = $this->connection->prepare('DELETE FROM tour_locations WHERE tour_location_id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return true;
    }

    public function getAllContent()
    {
        $stmt = $this->connection->prepare('SELECT * FROM history_info');
        $stmt->execute();
        $history = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $history;
    }

    /**
     * Summary of getContentById
     * @param mixed $id
     * @throws Exception
     */
    public function getContentById($id)
    {
        $stmt = $this->connection->prepare('SELECT * FROM history_info WHERE content_id = :id');
        $stmt->execute([':id' => $id]);
        $content = $stmt->fetch(PDO::FETCH_ASSOC);
        return $content;
    }

    /**
     * Summary of deleteContent
     * @param mixed $id
     * @throws Exception
     * @return bool
     */
    public function deleteContent($id)
    {
        $stmt = $this->connection->prepare('DELETE FROM history_info WHERE content_id = :id');
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return true;
    }

    public function addContent(HistoryContent $content)
    {
        $stmt = $this->connection->prepare('INSERT INTO history_info (title, description, image, url,section_type) VALUES (:title, :description, :image, :url , :section_type)');
        $stmt->execute([
            ':title'        => $content->getTitle(),
            ':description'  => $content->getDescription(),
            ':image'        => $content->getImage(),
            ':url'          => $content->getUrl(),
            ':section_type' => $content->getSectionType()
        ]);
        return true;
    }

    /**
     * Summary of updateContent
     * @param HistoryContent $content
     * @param mixed $id
     * @throws Exception
     * @return bool
     */
    public function updateContent(HistoryContent $content, $id)
    {
        $stmt = $this->connection->prepare('UPDATE history_info SET title = :title, description = :description, image = :image, url = :url , section_type = :section_type WHERE content_id = :id');
        $stmt->execute([
            ':title'        => $content->getTitle(),
            ':description'  => $content->getDescription(),
            ':image'        => $content->getImage(),
            ':url'          => $content->getUrl(),
            ':section_type' => $content->getSectionType(),
            ':id'           => $id
        ]);
        return true;
    }

    public function getAllTours()
    {
        $stmt = $this->connection->prepare('SELECT ht.date, ht.start_time, ht.end_time, tl.name, tl.flag_image, htour.available_guides, htour.tour_id
                                            FROM history_timeslots ht
                                            JOIN history_tours htour ON htour.timetable_id = ht.timetable_id
                                            JOIN tour_language tl ON tl.language_id = htour.language_id');
        $stmt->execute();
        $tour = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $tour;
    }
    public function getHistoryPageInfoBySectionType(string $sectionType): array
    {
        $stmt = $this->connection->prepare('SELECT * FROM history_info WHERE section_type = :section_type');
        $stmt->execute([':section_type' => $sectionType]);
        $info = $stmt->fetchAll(PDO::FETCH_ASSOC);

        error_log('Database query result: ' . print_r($info, true));
        return $info;
    }
    public function getFilteredTours($language = null, $availableGuides = false)
    {
        $sql = 'SELECT ht.date, ht.start_time, ht.end_time, tl.name, tl.flag_image, htour.available_guides, htour.tour_id
                FROM history_timeslots ht
                JOIN history_tours htour ON htour.timetable_id = ht.timetable_id
                JOIN tour_language tl ON tl.language_id = htour.language_id';

        $where = [];
        $params = [];

        if ($language) {
            $where[] = 'tl.name = :language';
            $params[':language'] = $language;
        }

        if ($availableGuides) {
            $where[] = 'htour.available_guides > 0';
        }

        if (!empty($where)) {
            $sql .= ' WHERE ' . implode(' AND ', $where);
        }

        $stmt = $this->connection->prepare($sql);
        $stmt->execute($params);
        $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $tours;
    }
    public function getOrderedTours(){
        $stmt = $this->connection->prepare('SELECT ht.date, ht.start_time, ht.end_time, tl.name, tl.flag_image, htour.available_guides
                                        FROM history_timeslots ht
                                        JOIN history_tours htour ON htour.timetable_id = ht.timetable_id
                                        JOIN tour_language tl ON tl.language_id = htour.language_id
                                        ORDER BY ht.date, ht.start_time');
        $stmt->execute();
        $tours = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Group by date
        $groupedTours = [];
        foreach ($tours as $tour) {
            $date = $tour['date'];
            if (!isset($groupedTours[$date])) {
                $groupedTours[$date] = [
                    'date'      => $date,
                    'day'       => date('l', strtotime($date)),
                    'timeslots' => []
                ];
            }
            $groupedTours[$date]['timeslots'][] = $tour;
        }
        return $groupedTours;
    }
}
