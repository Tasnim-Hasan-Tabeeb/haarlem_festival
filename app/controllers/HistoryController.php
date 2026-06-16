<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\View;
use App\Models\SectionType;
use App\Services\HistoryService;
use App\Services\PageService;
use Exception;
class HistoryController extends Controller
{
    private HistoryService $historyService;
    private PageService $pageService;
    public function __construct()
    {
        $this->historyService = new HistoryService();
        $this->pageService    = new PageService();
    }

    /**
     * Summary of index
     */
    public function index()
    {
        try{
            $pages          = $this->pageService->getAllActive();
            $headers        = $this->historyService->getHistoryPageInfoBySectionType(SectionType::Header);
            $introduction   = $this->historyService->getHistoryPageInfoBySectionType(SectionType::Introduction);
            $information    = $this->historyService->getHistoryPageInfoBySectionType(SectionType::Information);
            $regularTickets = $this->historyService->getHistoryPageInfoBySectionType(SectionType::RegularTicket);
            $familyTickets  = $this->historyService->getHistoryPageInfoBySectionType(SectionType::FamilyTicket);
            $routes         = $this->historyService->getHistoryPageInfoBySectionType(SectionType::Routes);
            $locations      = $this->historyService->getAllTourLocations();
            $tours          = $this->historyService->getOrderedTours();

            return View::make('frontend/history/index', [
                'headers'        => $headers,
                'introduction'   => $introduction,
                'information'    => $information,
                'regularTickets' => $regularTickets,
                'familyTickets'  => $familyTickets,
                'routes'         => $routes,
                'tours'          => $tours,
                'locations'      => $locations,
                'pages'          => $pages
            ]);
        }catch (Exception $e) {
            return $this->handleException($e, '/');
        }
    }

    /**
     * Summary of addTicket
     */
    public function addTicket(){
        try{
            $tours = $this->historyService->getAllTours();
            return View::make('frontend/history/historyTicket', compact('tours'));
        } catch (Exception $e) {
            return $this->handleException($e, '/');
        }
    }

    /**
     * Summary of getToursByLanguage
     * @return void
     */
    public function getToursByLanguage() {
        try {
            $language        = $_GET['language_name'] ?? null;
            $availableGuides = isset($_GET['availableGuides']) && $_GET['availableGuides'] === 'true';
            $tours           = $this->historyService->getFilteredTours($language, $availableGuides);
            echo json_encode($tours);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    /**
     * Summary of getTourLocations
     */
    public function getTourLocations(){
        try{
            $locations = $this->historyService->getAllTourLocations();
            return View::make('frontend/history/locationCarousel', compact('locations'));
        }catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
