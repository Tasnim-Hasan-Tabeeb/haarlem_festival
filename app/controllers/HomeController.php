<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\Helper;
use App\Helpers\View;
use App\Models\SectionType;
use App\Services\ArtistService;
use App\Services\DanceService;
use App\Services\EventService;
use App\Services\HistoryService;
use App\Services\OrderService;
use App\Services\PageService;
use App\Services\RestaurantService;
use App\Services\SectionService;
use App\Services\SessionService;
use App\Services\UserService;
use App\Services\VenueService;
use Exception;

class HomeController extends Controller
{
    protected PageService $pageService;
    protected SectionService $sectionService;
    protected SessionService $sessionService;
    protected RestaurantService $restaurantService;
    protected EventService $eventService;
    protected ArtistService $artistService;
    protected VenueService $venueService;
    protected DanceService$danceService;
    protected HistoryService  $historyService;
    private  UserService $userService;
    private OrderService $orderService;

    public function __construct()
    {
        $this->pageService       = new PageService();
        $this->sectionService    = new SectionService();
        $this->sessionService    = new SessionService();
        $this->restaurantService = new RestaurantService();
        $this->eventService      = new EventService();
        $this->artistService     = new ArtistService();
        $this->venueService      = new VenueService();
        $this->danceService      = new DanceService();
        $this->historyService    = new HistoryService();
        $this->userService       = new UserService();
        $this->orderService      = new OrderService();
    }

    /**
     * Summary of index
     */
    public function index()
    {
        try {
            $eventsData    = $this->eventService->getAll();
            $danceEvents   = [];
            $historyEvents = [];
            $yummyEvents   = [];

            $page                = $this->pageService->getPageBySlug('home');
            $sections            = $this->sectionService->getSectionByPageId((int) $page->getPageId());
            $section             = array_first($sections);
            $instrucationSection = array_last($sections);

            foreach ($eventsData as $event) {
                switch ($event['event_type']) {
                    case 'Dance':
                        $danceEvents[] = $event;
                        break;
                    case 'History':
                        $historyEvents[] = $event;
                        break;
                    case 'Yummy':
                        $yummyEvents[] = $event;
                        break;
                    default:
                        break;
                }
            }
            return View::make('frontend/home', compact('danceEvents', 'historyEvents', 'yummyEvents', 'section', 'instrucationSection'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Summary of dashboard
     */
    public function dashboard()
    {
        try {
            if (Helper::isAdmin()) {
                return $this->loadDashboardView();
            }
            return View::make('frontend/home');
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    /**
     * Summary of overview
     */
    public function overview()
    {
        return View::make('frontend/overview');
    }

    public function page()
    {
        try {
            $id   = $_GET['id']   ?? null;
            $slug = $_GET['slug'] ?? null;

            if (!$id || !$slug) {
                throw new Exception('Invalid page request');
            }

            return match ($slug) {
                'history' => $this->loadHistoryPage(),
                'yummy'   => $this->loadYummyPage($id),
                'dance'   => $this->loadDancePage(),
                default   => View::make('frontend/custom', [
                                            'sections' => $this->sectionService->getSectionByPageId($id),
                                            'title'    => ucfirst($slug)
                                        ])
            };
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Summary of loadHistoryPage
     *
     */
    private function loadHistoryPage()
    {
        return View::make('frontend/history/index', [
            'title'          => 'History',
            'headers'        => $this->historyService->getHistoryPageInfoBySectionType(SectionType::Header),
            'introduction'   => $this->historyService->getHistoryPageInfoBySectionType(SectionType::Introduction),
            'information'    => $this->historyService->getHistoryPageInfoBySectionType(SectionType::Information),
            'regularTickets' => $this->historyService->getHistoryPageInfoBySectionType(SectionType::RegularTicket),
            'familyTickets'  => $this->historyService->getHistoryPageInfoBySectionType(SectionType::FamilyTicket),
            'routes'         => $this->historyService->getHistoryPageInfoBySectionType(SectionType::Routes),
            'tours'          => $this->historyService->getOrderedTours(),
            'locations'      => $this->historyService->getAllTourLocations(),
        ]);
    }

    /**
     * Summary of loadYummyPage
     * @param mixed $id
     */
    private function loadYummyPage($id)
    {
        $restaurants = $this->restaurantService->getAllRestaurants();
        $title       = 'Yummy';
        foreach ($restaurants as &$restaurant) {
            $this->attachRestaurantTiming($restaurant);
        }

        $sections = $this->sectionService->getSectionByPageId($id);

        return View::make('frontend/yummy/index', compact('restaurants', 'sections', 'title'));
    }

    /**
     * Summary of attachRestaurantTiming
     * @param array $restaurant
     * @return void
     */
    private function attachRestaurantTiming(array &$restaurant): void
    {
        if (empty($restaurant['sessions'])) {
            $restaurant['start_time'] = null;
            $restaurant['end_time']   = null;
            return;
        }

        $latestSession = null;
        $latestTime    = null;

        foreach ($restaurant['sessions'] as $session) {
            $currentTime = strtotime($session['start_time']);

            if ($latestTime === null || $currentTime > $latestTime) {
                $latestTime    = $currentTime;
                $latestSession = $session;
            }
        }

        if ($latestSession) {
            $start = new \DateTime($latestSession['start_time']);
            $end   = (clone $start)->add(
                new \DateInterval('PT' . ($latestSession['duration'] * 60) . 'M')
            );

            $restaurant['start_time'] = $start->format('H:i');
            $restaurant['end_time']   = $end->format('H:i');
        }
    }

    /**
     * Summary of loadDancePage
     */
    private function loadDancePage()
    {
        $dancePageData = $this->danceService->getDancePageData();

        return View::make('frontend/dance/index', [
            'artists'      => $this->artistService->getAllArtists(),
            'venues'       => $this->venueService->getAllVenues(),
            'danceDays'    => $dancePageData['danceDays'],
            'allDatesPass' => $dancePageData['allDatesPass'],
            'title'        => 'Dance',
        ]);
    }

    /**
     * Summary of getDashboardData
     */
    private function loadDashboardView()
    {
        $userCount             = count($this->userService->getAllUsers());
        $pageCount             = count($this->pageService->getAllActive());
        $eventCount            = count($this->eventService->getAll());
        $restaurantCount       = count($this->restaurantService->getAllRestaurants());
        $danceEventCount       = count($this->danceService->getAllEvents());
        $artistCount           = count($this->artistService->getAllArtists());
        $venueCount            = count($this->venueService->getAllVenues());
        $historyLocationCount  = count($this->historyService->getAllTourLocations());
        $historytimetableCount = count($this->historyService->getAllTours());
        $orderCount            = count($this->orderService->getAllOrders());

        $dashboardStats = [
            'Users'             => $userCount,
            'Pages'             => $pageCount,
            'Events'            => $eventCount,
            'Orders'            => $orderCount,
            'Restaurants'       => $restaurantCount,
            'Dance Events'      => $danceEventCount,
            'Artists'           => $artistCount,
            'Venues'            => $venueCount,
            'History Locations' => $historyLocationCount,
            'History Tours'     => $historytimetableCount,
        ];

        return View::make(
            'backend/home',
            compact(
                'dashboardStats',
                'userCount',
                'pageCount',
                'eventCount',
                'orderCount',
                'restaurantCount',
                'danceEventCount',
                'artistCount',
                'venueCount',
                'historyLocationCount',
                'historytimetableCount'
            )
        );
    }
}
