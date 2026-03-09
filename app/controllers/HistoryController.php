<?php
namespace App\Controllers;
use App\Services\HistoryService;
use App\Services\PageService;
use Exception;
use App\Models\SectionType;
class HistoryController
{
    private HistoryService $historyService;
    private PageService $pageService;
    public function __construct()
    {
        $this->historyService = new HistoryService();
        $this->pageService = new PageService();
    }
    public function index()
    {
        try{
            $pages = $this->pageService->getAllActive();

            $headers = $this->historyService->getHistoryPageInfoBySectionType(SectionType::Header);
            $introduction = $this->historyService->getHistoryPageInfoBySectionType(SectionType::Introduction);
            $information = $this->historyService->getHistoryPageInfoBySectionType(SectionType::Information);
            $regularTickets = $this->historyService->getHistoryPageInfoBySectionType(SectionType::RegularTicket);
            $familyTickets = $this->historyService->getHistoryPageInfoBySectionType(SectionType::FamilyTicket);
            $routes = $this->historyService->getHistoryPageInfoBySectionType(SectionType::Routes);
            $locations = $this->historyService->getAllTourLocations();
            $tours = $this->historyService->getOrderedTours();
            require_once __DIR__ . '/../views/frontend/history/index.php';
        }catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }
    public function addTicket(){
        try{
            $tours = $this->historyService->getAllTours();
            require_once  __DIR__ . '/../views/frontend/history/historyTicket.php';
        } catch (Exception $e) {
            header("Location: /error?message=" . urlencode($e->getMessage()));
            exit();
        }
    }
    public function getToursByLanguage() {
        try {
            $language = $_GET['language_name'] ?? null;
            $availableGuides = isset($_GET['availableGuides']) && $_GET['availableGuides'] === 'true';

            $tours = $this->historyService->getFilteredTours($language, $availableGuides);
            echo json_encode($tours);
        } catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
    public function getTourLocations(){
        try{
            $locations = $this->historyService->getAllTourLocations();
//            echo json_encode($locations);
            require_once __DIR__ . '/../views/frontend/history/locationCarousel.php';
        }catch (Exception $e) {
            echo json_encode(['error' => $e->getMessage()]);
        }
    }
}
