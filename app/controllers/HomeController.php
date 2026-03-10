<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Models\SectionType;
use App\Services\EventService;
use App\Services\PageService;
use App\Services\RestaurantService;
use App\Services\ArtistService;
use App\Services\UserService;
use App\Services\OrderService;
use App\Services\VenueService;
use App\Services\DanceService;
use App\Services\SectionService;
use App\Services\SessionService;
use Exception;

class HomeController
{
    protected $pageService;
    protected $sectionService;
    protected $sessionService;
    protected $restaurantService;
    protected $eventService;

    protected $artistService;
    protected $venueService;
    protected $danceService;
    private $userService;
    private $orderService;

    public function __construct()
    {
        $this->pageService = new PageService();
        $this->sectionService = new SectionService();
        $this->sessionService = new SessionService();
        $this->restaurantService = new RestaurantService();
        $this->eventService = new EventService();
        $this->artistService = new ArtistService();
        $this->venueService = new VenueService();
        $this->danceService = new DanceService();
        $this->userService = new UserService();
        $this->orderService = new OrderService();
    }


    public function index()
    {
        try {
            // Fetch all events
            $eventsData = $this->eventService->getAll();

            // Initialize arrays to store data for each enum
            $danceEvents = [];
            $yummyEvents = [];

            // Iterate through the events data
            foreach ($eventsData as $event) {
                // Check the value of the 'event_type' enum
                switch ($event['event_type']) {
                    case 'Dance':
                        $danceEvents[] = $event;
                        break;
                    case 'Yummy':
                        $yummyEvents[] = $event;
                        break;
                    default:
                        break;
                }
            }
            require __DIR__ . '/../views/frontend/home.php';
        } catch (Exception $e) {
            // Handle exceptions
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }


    public function dashboard()
    {
        if (isset($_SESSION['role']) && $_SESSION['role'] == "Admin") {

            $users = $this->userService->getAllUsers();
            $userCount = count($users);

            $pages = $this->pageService->getAllActive();
            $pageCount = count($pages);

            $events = $this->eventService->getAll();
            $eventCount = count($events);

            $restaurants = $this->restaurantService->getAllRestaurants();
            $restaurantCount = count($restaurants);

            $danceEvents = $this->danceService->getAllEvents();
            $danceEventCount = count($danceEvents);

            $artists = $this->artistService->getAllArtists();
            $artistCount = count($artists);

            $venues = $this->venueService->getAllVenues();
            $venueCount = count($venues);

            $orders = $this->orderService->getAllOrders();
            $orderCount = count($orders);

            require __DIR__ . '/../views/backend/home.php';
        } else {
            require __DIR__ . '/../views/frontend/home.php';
        }
    }

    public function overview()
    {
        require __DIR__ . '/../views/frontend/overview.php';
    }

    public function create()
    {
        require '../views/backend/users/create.php';
    }

    /**
     * @throws Exception
     */
    public function page()
    {
        $id = $_GET['id'];
        $slug = $_GET['slug'];
        $sections = $this->sectionService->getSectionByPageId($id);        
        switch ($slug) {
            case 'yummy':
                $restaurants = $this->restaurantService->getAllRestaurants();
                foreach ($restaurants as &$restaurant) {
                    if (!empty($restaurant['sessions'])) {
                        $latestStartTime = null;
                        $latestSession = null;

                        foreach ($restaurant['sessions'] as $session) {
                            $sessionStartTime = new \DateTime($session['start_time']);
                            if ($latestStartTime === null || $sessionStartTime > $latestStartTime) {
                                $latestStartTime = $sessionStartTime;
                                $latestSession = $session;
                            }
                        }

                        if ($latestSession !== null) {
                            $end_time = clone $latestStartTime;
                            $end_time->add(new \DateInterval('PT' . ($latestSession['duration'] * 60) . 'M'));
                            $restaurant['start_time'] = $latestStartTime->format('H:i');
                            $restaurant['end_time'] = $end_time->format('H:i');
                        }
                    } else {
                        $restaurant['start_time'] = null;
                        $restaurant['end_time'] = null;
                    }
                }
                unset($restaurant);
//                Helper::debug($restaurants);
                require '../views/frontend/yummy/index.php';
                break;
            case 'dance':
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
                break;
            default:
                require '../views/frontend/custom.php';
                break;
        }
    }
}
