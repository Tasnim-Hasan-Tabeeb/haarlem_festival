<?php

namespace App\Services;

use App\Helpers\Validator;
use App\Models\Dance;
use App\Models\TicketPass;
use App\Repositories\DanceRepository;
use App\Traits\Fileable;
use Exception;

class DanceService
{
    use Fileable;
    private DanceRepository $danceRepository;
    private DancePageDataBuilder $pageDataBuilder;

    public function __construct(
        ?DanceRepository $danceRepository = null,
        ?DancePageDataBuilder $pageDataBuilder = null
    ) {
        $this->danceRepository = $danceRepository ?? new DanceRepository();
        $this->pageDataBuilder = $pageDataBuilder ?? new DancePageDataBuilder();
    }

    public function getAllEvents()
    {
        try {
            return $this->danceRepository->getAll();
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    public function getDancePageData(): array
    {
        try {
            return $this->pageDataBuilder->build(
                $this->danceRepository->getActiveEvents(),
                $this->danceRepository->getAllPasses()
            );
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    public function getEventsByDate(string $date)
    {
        try {
            return $this->danceRepository->getEventsByDate($date);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    public function getArtistIdsByEventId(int $music_event_id){
        try {
            return $this->danceRepository->getArtistIdsByEventId($music_event_id);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    public function getEventById(int $music_performance_id)
    {
        try {
            return $this->danceRepository->getDanceEventById($music_performance_id);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    /**
     * Summary of storeDance
     * @throws Exception
     * @return bool
     */
    public function storeDance()
    {
        $rules = [
            'event_price'       => 'required|numeric|min:0|max:10000000',
            'session_type'      => 'required|string',
            'event_date'        => 'required|date',
            'event_start_time'  => 'required|date',
            'event_duration'    => 'required|numeric|min:0|max:2400000',
            'event_name'        => 'required|string|max:255',
            'event_id'          => 'required|numeric',
            'venue_id'          => 'required|numeric',
            'artist_id'         => 'required_array|numeric',
            'music_event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        Validator::validate($_POST, $rules);

        $imageUrl = '/images/default.webp';

        if (isset($_FILES['music_event_image']) && $_FILES['music_event_image']['error'] === UPLOAD_ERR_OK) {
            $file     = $_FILES['music_event_image'];
            $imageUrl = $this->uploadImage($file);
        }

        $artistIds = $_POST['artist_id'] ?? [];

        if (empty($artistIds)) {
            throw new Exception('Select at least one artist');
        }

        $dance = new Dance(
            0,
            0,
            $_POST['event_price'],
            $_POST['session_type'],
            $_POST['event_date'],
            $_POST['event_start_time'],
            $_POST['event_duration'],
            $_POST['event_name'],
            $_POST['event_id'],
            1,
            $_POST['venue_id'],
            $imageUrl
        );

        return $this->danceRepository->store($dance, $artistIds);
    }

    /**
     * Summary of updateDance
     * @throws Exception
     * @return bool
     */
    public function updateDance()
    {
        $rules = [
            'music_event_id'    => 'required|numeric',
            'event_price'       => 'required|numeric|min:0|max:10000000',
            'session_type'      => 'required|string',
            'event_date'        => 'required|date',
            'event_start_time'  => 'required|date',
            'venue_id'          => 'required|numeric',
            'event_duration'    => 'required|numeric|min:0|max:2400000',
            'event_name'        => 'required|string|max:255',
            'event_id'          => 'required|numeric',
            'artist_id'         => 'required_array|numeric',
            'music_event_image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ];

        Validator::validate($_POST, $rules);

        $imageUrl = '/images/default.webp';

        $musicEventId = $_POST['music_event_id'];

        $event = $this->danceRepository->getMusicEventById($musicEventId);

        if ($event['music_event_image'] !== '/images/default.webp') {
            $imageUrl = $event['music_event_image'];
        }

        if (isset($_FILES['music_event_image']) && $_FILES['music_event_image']['error'] === UPLOAD_ERR_OK) {
            $file = $_FILES['music_event_image'];
            $this->unlinkImage($event['music_event_image']);
            $imageUrl = $this->uploadImage($file);
        }

      
        $artistIds = $_POST['artist_id'] ?? [];

        if (empty($artistIds)) {
            throw new Exception('Select at least one artist');
        }

        $dance = new Dance(
            0,
            $_POST['music_event_id'],
            $_POST['event_price'],
            $_POST['session_type'],
            $_POST['event_date'],
            $_POST['event_start_time'],
            $_POST['event_duration'],
            $_POST['event_name'],
            $_POST['event_id'],
            1,
            $_POST['venue_id'],
            $imageUrl
        );

        return $this->danceRepository->update($dance, $artistIds);
    }

    public function deleteDance(int $music_performance_id)
    {
        try {
            return $this->danceRepository->delete($music_performance_id);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    public function getAllPasses()
    {
        try {
            return $this->danceRepository->getAllPasses();
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }
    public function getEventsByArtistId(int $artistId)
    {
        try {
            return $this->danceRepository->getEventsByArtistId($artistId);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }
    public function getPassDetailsById(int $passId)
    {
        try {
            return $this->danceRepository->getPassDetailsById($passId);
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    public function createPass()
    {
        try {
            Validator::validate($_POST, ['pass_id' => 'required|numeric']);

            $passId = (int) $_POST['pass_id'];
            $passDetails = $this->getPassDetailsById($passId);
            if (!$passDetails) {
                throw new Exception('Pass not found');
            }

            $pass = new TicketPass(
                (int) $passDetails['pass_id'],
                $passDetails['passName'],
                $passDetails['passDescription'],
                (int) $passDetails['passPrice'],
                $passDetails['passType'],
                $passDetails['pass_scope'],
                $passDetails['event_date'],
                1
            );

            return $pass;
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }

    public function createDanceForCart(){
        try {
            Validator::validate(
                $_POST,
                ['music_performance_id' => 'required']
            );
            $musicPerformanceId = $_POST['music_performance_id'] ?? null;

            $event = $this->getEventById($musicPerformanceId);

            if (!$event) {
                throw new Exception('Event not found');
            }

            $dance = new Dance(
                $event['music_performance_id'],
                $event['music_event_id'],
                $event['event_price'],
                $event['session_type'],
                $event['event_date'],
                $event['event_start_time'],
                $event['event_duration'],
                $event['event_name'],
                $event['event_id'],
                1,
                $event['venue_id'],
            );

            return $dance;
        } catch (Exception $e) {
            throw new Exception('Error: ' . $e->getMessage());
        }
    }
}
