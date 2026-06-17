<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\View;
use App\Services\OrderService;
use Exception;

class ScanTicketController extends Controller
{
    private OrderService $orderService;

    public function __construct()
    {
        $this->orderService = new OrderService();
        set_error_handler([$this, 'handleErrors']);
    }

    public function scanTicket(): void
    {
        try {
            return View::make('frontend.scan-ticket');
        } catch (Exception $e) {
            return $this->handleException($e);
        }
    }

    public function verifyTicket(): void
    {
        try {
            $postData      = file_get_contents('php://input');
            $postDataArray = json_decode($postData, true);

            if (isset($postDataArray['code'])) {
                $qrCode = $postDataArray['code'];
                $ticket = $this->orderService->getTicketWithQRCode($qrCode);

                if ($ticket && $ticket['status'] === 'new') {
                    // Check if ticket is already scanned
                    if ($ticket['status'] === 'used') {
                        $response = [
                            'success' => false,
                            'message' => 'This ticket has already been scanned.'
                        ];
                        echo json_encode($response);
                        exit();
                    }

                    // Update ticket status to 'scanned'
                    $success = $this->orderService->updateTicketStatus($qrCode);
                    if ($success) {
                        $response = [
                            'success' => true,
                            'message' => 'Ticket status updated to Scanned.'
                        ];
                    } else {
                        $response = [
                            'success' => false,
                            'message' => 'There was a problem with updating the ticket status. Please try again.'
                        ];
                    }
                } else {
                    $response = [
                        'success' => false,
                        'message' => 'This is not a valid or paid ticket.'
                    ];
                }
            } else {
                $response = [
                    'success' => false,
                    'message' => 'Invalid QR code data.'
                ];
            }
            echo json_encode($response);
        } catch (\Exception $e) {
            $response = [
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage()
            ];
            echo json_encode($response);
        }
    }

    public function handleErrors($errno, $errstr, $errfile, $errline)
    {
        $response = [
            'success' => false,
            'message' => "Error: [$errno] $errstr - $errfile:$errline"
        ];
        echo json_encode($response);
        exit();
    }
}
