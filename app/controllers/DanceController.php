<?php

namespace App\Controllers;
use App\Services\Basket;
use App\Helpers\Helper;
use App\Models\Artist;
use App\Models\Dance;
use App\Models\TicketPass;
use App\Models\Venue;
use App\Services\ArtistService;
use App\Services\DanceService;
use App\Services\PageService;
use App\Services\VenueService;
use Exception;

class DanceController{
    private DanceService $danceService;
    private ArtistService $artistService;
    private VenueService $venueService;
    private pageService $pageService;
    private $basket;


    public function __construct()
    {
        $this->danceService = new DanceService();
        $this->artistService = new ArtistService();
        $this->venueService = new VenueService();
        $this->basket = new Basket();
        $this->pageService = new PageService();
    }
    public function index()
    {
        $artists = $this->artistService->getAllArtists();
        $venues = $this->venueService->getAllVenues();
        $passes = $this->danceService->getAllPasses();
        $fridayTickets = $this->danceService->getfridayEvents();
        $saturdayTickets = $this->danceService->getSaturdayEvents();
        $SundayTickets = $this->danceService->getSundayEvents();



        $fridayPass = [];
        $saturdayPass = [];
        $sundayPass = [];
        $allAccessPass = [];

        foreach ($passes as $pass) {
            switch ($pass['passType']) {
                case 'One-Day Pass (Friday)':
                    $fridayPass[] = $pass;
                    break;
                case 'One-Day Pass (Saturday)':
                    $saturdayPass[] = $pass;
                    break;
                case 'One-Day Pass (Sunday)':
                    $sundayPass[] = $pass;
                    break;
                case 'All-Access Pass':
                    $allAccessPass[] = $pass;
                    break;
                default:
                    break;
            }
        }
        require __DIR__ . '/../views/frontend/dance/index.php';
    }
    public function artists()
    {
        $artistID = $_GET['id'];
        $artists = $this->artistService->getArtistsById($artistID);
        $artistEvents = $this->danceService->getEventsByArtistId($artistID);
        $artistAlbums = $this->artistService->getArtistsAlbum($artistID);
        $artistMusic = $this->artistService->getArtistMusic($artistID);
        $artistAwards = $this->artistService->getArtistAwards($artistID);


        require __DIR__ . '/../views/frontend/dance/artists.php';
    }
    public function addPassToBasket()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Method Not Allowed']);
            exit();
        }

        $passType = $_POST['pass_type'] ?? null;
        if (!$passType) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Pass type is required']);
            exit();
        }

        try {
            $passDetails = $this->danceService->getPassDetailsByType($passType);
            if (!$passDetails) {
                throw new Exception('Pass not found');
            }

            $pass = new TicketPass(
                $passDetails['pass_id'],
                $passDetails['passName'],
                $passDetails['passDescription'],
                $passDetails['passPrice'],
                $passDetails['passType'],
                1
            );

            $this->basket->addItem($pass);

            echo json_encode(['success' => true]);
            exit();
        } catch (Exception $e) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
    }

    public function create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405); // Method Not Allowed
            echo json_encode(['error' => 'Method Not Allowed']);
            exit();
        }

        $musicPerformanceId = $_POST['music_performance_id'] ?? null;
        if (!$musicPerformanceId) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => 'Music performance ID is required']);
            exit();
        }

        try {
            $event = $this->danceService->getEventById($musicPerformanceId);
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
                1
            );

            $this->basket->addItem($dance);

            echo json_encode(['success' => true]);
            exit();
        } catch (Exception $e) {
            http_response_code(400); // Bad Request
            echo json_encode(['error' => $e->getMessage()]);
            exit();
        }
    }

}