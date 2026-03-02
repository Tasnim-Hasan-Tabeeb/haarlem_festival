<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Models\SectionType;
use App\Services\EventService;
use App\Services\HistoryService;
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
    protected $historyService;
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
        //$this->historyService = new HistoryService();
        $this->userService = new UserService();
        $this->orderService = new OrderService();
    }


    public function dashboard()
    {
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

            //$historyLocations = $this->historyService->getAllTourLocations();
            //$historyLocationCount = count($historyLocations);

            //$historytimetable = $this->historyService->getAllTours();
           // $historytimetableCount = count($historytimetable);

            $orders = $this->orderService->getAllOrders();
            $orderCount = count($orders);

            require __DIR__ . '/../views/backend/home.php';
    }

    public function create()
    {
        require '../views/backend/users/create.php';
    }

}
