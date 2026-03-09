<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Models\HistoryTicket;
use App\Models\TicketType;
use App\Services\Basket;
use App\Services\HistoryService;
use DateTime;
use Exception;

class HistoryTicketController
{
    private $historyService;
    private $basketService;

    public function __construct()
    {
        $this->historyService = new HistoryService();
        $this->basketService = new Basket();
    }
    public function create()
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);
            $ticketTypeStr = isset($input['ticketType']) ? htmlspecialchars(trim($input['ticketType']), ENT_QUOTES, 'UTF-8') : null;
            $price = isset($input['price']) ? floatval($input['price']) : null;
            $start_location = isset($input['start_location']) ? htmlspecialchars(trim($input['start_location']), ENT_QUOTES, 'UTF-8') : null;
            $timeslot = isset($input['timeslot']) ? htmlspecialchars(trim($input['timeslot']), ENT_QUOTES, 'UTF-8') : null;
            $participants = isset($input['participants']) ? intval($input['participants']) : null;

            var_dump($ticketTypeStr, $price, $start_location, $timeslot, $participants); // Debugging line

//            if (empty($ticketTypeStr) || empty($price) || empty($start_location) || empty($timeslotStr)) {
//                throw new Exception('Incomplete data received.');
//            }
            $ticketType = TicketType::createFrom($ticketTypeStr);
            if (!$ticketType) {
                throw new Exception('Invalid ticket type.');
            }

            $historyTicket = new HistoryTicket($ticketType, $price, $start_location, $timeslot, $participants);
            $this->basketService->addItem($historyTicket);

            echo json_encode(['success' => true]);
            exit();
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
            exit();
        }
    }
}