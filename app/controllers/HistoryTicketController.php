<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\Validator;
use App\Models\HistoryTicket;
use App\Models\TicketType;
use App\Services\Basket;
use Exception;

class HistoryTicketController extends Controller
{
    private Basket $basketService;

    public function __construct()
    {
        $this->basketService = new Basket();
    }

    /**
     * Summary of create
     * @throws Exception
     * @return void
     */
    public function create()
    {
        try {
            $input = json_decode(file_get_contents('php://input'), true);

            $rules = [
                'ticketType'     => 'required|string',
                'price'          => 'required|numeric|min:0',
                'start_location' => 'required|string',
                'timeslot'       => 'required|string',
                'participants'   => 'required|numeric|min:1|max:10000',
            ];

            Validator::validate($input, $rules);

            $ticketTypeStr  = htmlspecialchars(trim($input['ticketType']), ENT_QUOTES, 'UTF-8');
            $price          = floatval($input['price']);
            $start_location = htmlspecialchars(trim($input['start_location']), ENT_QUOTES, 'UTF-8');
            $timeslot       = htmlspecialchars(trim($input['timeslot']), ENT_QUOTES, 'UTF-8');
            $participants   = intval($input['participants']);

            $ticketType = TicketType::createFrom($ticketTypeStr);

            if (!$ticketType) {
                throw new Exception('Invalid ticket type.');
            }

            $historyTicket = new HistoryTicket($ticketType, $price, $start_location, $timeslot, $participants);
            $this->basketService->addItem($historyTicket);

            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
    }
}
