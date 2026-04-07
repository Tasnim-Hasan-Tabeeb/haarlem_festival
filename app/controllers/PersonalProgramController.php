<?php

namespace App\Controllers;

use App\Helpers\Helper;
use App\Models\Reservation;
use App\Models\Ticket;
use App\Services\Basket;
use App\Services\OrderService;
use App\Services\ReservationService;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelHigh;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Stripe\Checkout\Session;

use Stripe\Stripe;
use TCPDF;
class PersonalProgramController
{
    private $reservationService;
    private $orderService;
    private $basket;

    public function __construct()
    {
        $this->basket             = new Basket();
        $this->reservationService = new ReservationService();
        $this->orderService       = new OrderService();
    }

    public function basket()
    {
        try {
            $cartItems = $this->basket->getAllItems();
            require __DIR__ . '/../views/frontend/basket.php';
        } catch (Exception $e) {
            $_SESSION['isError']       = 1;
            $_SESSION['flash_message'] = ($e->getMessage());
            $redirect                  = $_SERVER['HTTP_REFERER'] ?? '/personalprogram/basket';
            header('Location: ' . $redirect);
            exit();
        }
    }

    public function removeItem()
    {
        try {
            $index = $_GET['index'];
            $this->basket->removeItem($index);
            header('Location: /personalprogram/basket');
            exit();
        } catch (Exception $e) {
            $_SESSION['isError']       = 1;
            $_SESSION['flash_message'] = ($e->getMessage());
            $redirect                  = $_SERVER['HTTP_REFERER'] ?? '/personalprogram/basket';
            header('Location: ' . $redirect);
            exit();
        }
    }

    public function checkout()
    {
        $key = 'sk_test_51PS8HHF7UbSXoXFVQFRcOjx7b6nffHvGpqbNQngGmuaiOmyqxRA3IywweJclE1X0bTwFEkDBXUEwvkj0haSUPPfP00JhIdhACj';

        if (!isset($_SESSION['user'])) {
            $_SESSION['isError']       = 1;
            $_SESSION['flash_message'] = 'You must be logged in to checkout';

            $redirect = $_SERVER['HTTP_REFERER'] ?? '/login/login';
            header('Location: ' . $redirect);
            exit();
        }

        $user = $_SESSION['user'];

        try {
            $cartItems   = $this->basket->getAllItems();
            $lineItems   = [];
            $totalAmount = 0;

            foreach ($cartItems as $cartItem) {
                $unitAmount = isset($cartItem['cost_per_person']) ? $cartItem['cost_per_person'] : $cartItem['cost'];

                $quantity    = isset($cartItem['total_adult']) ? $cartItem['total_adult'] + $cartItem['total_children'] : (isset($cartItem['quantity']) ? $cartItem['quantity'] : $cartItem['participants']);
                $productName = isset($cartItem['name']) ? 'Reservation' : (isset($cartItem['ticketType']) ? 'Ticket for ' . $cartItem['start_location'] : (isset($cartItem['passType']) ? 'Pass: ' . $cartItem['passType'] : 'Dance Ticket'));

                $lineItems[] = [
                    'price_data' => [
                        'currency'     => 'eur',
                        'product_data' => [
                            'name' => $productName,
                        ],
                        'unit_amount' => (int) round($unitAmount * 100), // Amount in cents
                    ],
                    'quantity' => $quantity,
                ];

                $totalAmount += $unitAmount * $quantity;
            }

            // Calculate the tax amount
            $taxAmount          = $totalAmount * 0.21;
            $totalAmountWithTax = $totalAmount + $taxAmount;

            // Add the tax as a separate line item
            $lineItems[] = [
                'price_data' => [
                    'currency'     => 'eur',
                    'product_data' => [
                        'name' => 'Tax (21%)',
                    ],
                    'unit_amount' => (int) round($taxAmount * 100), // Amount in cents
                ],
                'quantity' => 1,
            ];

            Stripe::setApiKey($key);

            $session = Session::create([
                'payment_method_types' => ['ideal', 'card'],
                'line_items'           => $lineItems,
                'mode'                 => 'payment',
                'client_reference_id'  => $user['user_id'],

                'customer_email' => $user['email'] ?? '',

                'metadata' => [
                    'user_id'    => $user['user_id'],
                    'user_email' => $user['email'] ?? '',
                    'name'       => $user['name']  ?? '',
                ],
                'success_url' => 'http://localhost/personalprogram/success?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url'  => 'http://localhost/personalprogram/cancel',
            ]);

            header('Location: ' . $session->url);
            exit();
        } catch (Exception $e) {
            $_SESSION['isError']       = 1;
            $_SESSION['flash_message'] = ($e->getMessage());

            $redirect = $_SERVER['HTTP_REFERER'] ?? '/login/login';
            header('Location: ' . $redirect);
            exit();
        }
    }

    public function success()
    {
        try {
            $sessionId = $_GET['session_id'];
            Stripe::setApiKey('sk_test_51PS8HHF7UbSXoXFVQFRcOjx7b6nffHvGpqbNQngGmuaiOmyqxRA3IywweJclE1X0bTwFEkDBXUEwvkj0haSUPPfP00JhIdhACj');
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                $cartItems   = $this->basket->getAllItems();
                $totalAmount = 0;

                foreach ($cartItems as $cartItem) {
                    $totalAmount += isset($cartItem['cost_per_person']) ? $cartItem['cost_per_person'] * ($cartItem['total_adult'] + $cartItem['total_children']) : $cartItem['cost'];
                }

                $userId = $session->client_reference_id;

                $name  = $session->metadata->name;
                $email = $session->metadata->user_email;

                $orderId = $this->orderService->createOrder($userId, $totalAmount);

                $ticketDetails  = [];
                $invoiceDetails = [];

                foreach ($cartItems as $cartItem) {
                    if (isset($cartItem['reservation_date'])) {
                        $reservation = new Reservation(
                            $cartItem['name'],
                            $cartItem['reservation_date'],
                            $cartItem['total_adult'],
                            $cartItem['total_children'],
                            $cartItem['email'],
                            $cartItem['phone'],
                            $userId,
                            $cartItem['session_id'],
                            $cartItem['restaurant_id'],
                            $cartItem['remarks'],
                            $cartItem['cost_per_person']
                        );

                        $reservation->setPaymentStatus('completed');
                        $reservationId = $this->reservationService->createReservation($reservation);
                        $this->orderService->addOrderItem($orderId, 'reservation', $reservationId);

                        $invoiceDetails[] = [
                            'type'       => 'Reservation',
                            'details'    => $reservation->getName() . ' - ' . $reservation->getReservationDate(),
                            'quantity'   => $reservation->getTotalAdult() + $reservation->getTotalChildren(),
                            'price'      => $reservation->getCost() / ($reservation->getTotalAdult() + $reservation->getTotalChildren()),
                            'total_cost' => $reservation->getCost()
                        ];
                    } elseif (isset($cartItem['ticketType'])) {
                        $qrCode = $this->generateUniqueQrCode();
                        $ticket = new Ticket(
                            $name,
                            $cartItem['start_location'],
                            explode(' ', $cartItem['timeslot'])[0],
                            explode('-', explode(' ', $cartItem['timeslot'])[1])[0],
                            $qrCode
                        );

                        $ticketId = $this->orderService->createTicket($ticket);

                        $this->orderService->addOrderItem($orderId, 'history_ticket', $ticketId);

                        $ticketDetails[] = array_merge($ticket->toArray(), ['qr_code_path' => $qrCode]);

                        $invoiceDetails[] = [
                            'type'       => 'History Ticket',
                            'details'    => $cartItem['start_location'] . ' - ' . $cartItem['timeslot'],
                            'quantity'   => $cartItem['participants'],
                            'price'      => $cartItem['price'],
                            'total_cost' => $cartItem['cost']
                        ];
                    } elseif (isset($cartItem['passName'])) {
                        $qrCode = $this->generateUniqueQrCode();
                        $ticket = new Ticket(
                            $name,
                            $cartItem['passName'],
                            null,
                            null,
                            $qrCode
                        );

                        $ticketId = $this->orderService->createTicket($ticket);
                        $this->orderService->addOrderItem($orderId, 'dance_pass', $ticketId);

                        $ticketDetails[] = array_merge($ticket->toArray(), ['qr_code_path' => $qrCode]);

                        $invoiceDetails[] = [
                            'type'       => 'Dance Pass',
                            'details'    => $cartItem['passName'],
                            'quantity'   => $cartItem['quantity'],
                            'price'      => $cartItem['passPrice'],
                            'total_cost' => $cartItem['cost']
                        ];
                    } elseif (isset($cartItem['music_performance_id'])) {
                        $qrCode = $this->generateUniqueQrCode();
                        $ticket = new Ticket(
                            $name,
                            $cartItem['event_name'],
                            $cartItem['event_date'],
                            $cartItem['event_start_time'],
                            $qrCode
                        );

                        $ticketId = $this->orderService->createTicket($ticket);
                        $this->orderService->addOrderItem($orderId, 'dance_ticket', $ticketId);

                        $ticketDetails[] = array_merge($ticket->toArray(), ['qr_code_path' => $qrCode]);

                        $invoiceDetails[] = [
                            'type'       => 'Dance Ticket',
                            'details'    => $cartItem['event_name'] . ' - ' . $cartItem['event_date'] . ' ' . $cartItem['event_start_time'],
                            'quantity'   => $cartItem['quantity'],
                            'price'      => $cartItem['event_price'],
                            'total_cost' => $cartItem['cost']
                        ];
                    }
                }

                $invoicePdf = $this->generateInvoicePdf($invoiceDetails);

                $this->sendInvoiceEmail($email, $name, $invoicePdf);

                $qrCodeImagePaths = $this->getQR($orderId); // Generate QR codes and get their paths
                $ticketPdf        = $this->generateTicketPdf($ticketDetails);

                if($ticketPdf && is_array($qrCodeImagePaths) && count( $qrCodeImagePaths) != 0 ) {
                  $this->sendTicketEmail($email, $name, $ticketPdf, $qrCodeImagePaths);
                }

                $this->basket->clearBasket();

                Helper::setMessage(false, 'Reservations and tickets confirmed and stored successfully!');
                header('Location: /personalprogram/basket');
                exit();
            } else {
                throw new Exception('Payment was not successful.');
            }
        } catch (Exception $e) {
            $_SESSION['isError']       = 1;
            $_SESSION['flash_message'] = ($e->getMessage());

            $redirect = $_SERVER['HTTP_REFERER'] ?? '/login/login';
            header('Location: ' . $redirect);
        }
    }

    private function generateInvoicePdf($invoiceDetails)
    {
        // Include TCPDF library
        require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';

        // Create new PDF document
        $pdf = new TCPDF();
        $pdf->AddPage();

        // Set PDF metadata
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Invoice');
        $pdf->SetSubject('Invoice for your purchase');
        $pdf->SetKeywords('TCPDF, PDF, invoice');

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Add invoice content
        $html        = '<h1>Invoice</h1><table border="1" cellpadding="5"><tr><th>Type</th><th>Details</th><th>Quantity</th><th>Price</th><th>Total Cost</th></tr>';
        $totalAmount = 0;

        foreach ($invoiceDetails as $detail) {
            $totalAmount += $detail['total_cost'];
            $html .= '<tr>
                    <td>' . htmlspecialchars($detail['type'], ENT_QUOTES, 'UTF-8') . '</td>
                    <td>' . htmlspecialchars($detail['details'], ENT_QUOTES, 'UTF-8') . '</td>
                    <td>' . htmlspecialchars($detail['quantity'], ENT_QUOTES, 'UTF-8') . '</td>
                    <td>' . htmlspecialchars($detail['price'], ENT_QUOTES, 'UTF-8') . ' EUR</td>
                    <td>' . htmlspecialchars($detail['total_cost'], ENT_QUOTES, 'UTF-8') . ' EUR</td>
                  </tr>';
        }

        $taxAmount    = $totalAmount * 0.21;
        $totalWithTax = $totalAmount + $taxAmount;

        $html .= '<tr>
                <td colspan="4" style="text-align: right;"><strong>Subtotal</strong></td>
                <td>' . htmlspecialchars($totalAmount, ENT_QUOTES, 'UTF-8') . ' EUR</td>
              </tr>';
        $html .= '<tr>
                <td colspan="4" style="text-align: right;"><strong>Tax (9%)</strong></td>
                <td>' . htmlspecialchars($taxAmount, ENT_QUOTES, 'UTF-8') . ' EUR</td>
              </tr>';
        $html .= '<tr>
                <td colspan="4" style="text-align: right;"><strong>Total Amount</strong></td>
                <td>' . htmlspecialchars($totalWithTax, ENT_QUOTES, 'UTF-8') . ' EUR</td>
              </tr>';

        $html .= '</table>';

        // Output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // Define the directory path for storing invoice PDFs
        $directoryPath = __DIR__ . '/../public/invoices/';

        // Check if the directory exists, if not, create it
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        // Define the file path for the invoice PDF
        $pdfPath = $directoryPath . 'invoice_' . uniqid() . '.pdf';

        // Output PDF document to the defined path
        $pdf->Output($pdfPath, 'F');

        return $pdfPath;
    }

    private function sendInvoiceEmail($email, $name, $invoicePdf)
    {
        $mailConfig = require __DIR__ . '/../config/mail.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = $mailConfig['host'];
            $mail->SMTPAuth   = $mailConfig['SMTPAuth'];
            $mail->Username   = $mailConfig['username'];
            $mail->Password   = $mailConfig['password'];
            $mail->SMTPSecure = $mailConfig['SMTPSecure'];
            $mail->Port       = $mailConfig['port'];

            $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = 'Invoice';
            $mail->Body    = 'Please find the attached invoice for your recent reservation and purchases.';

            $mail->addStringAttachment(
                file_get_contents($invoicePdf),
                'invoice.pdf',
                'base64',
                'application/pdf'
            );
            $mail->send();
        } catch (Exception $e) {
            error_log("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
        }
    }

    private function generateTicketPdf($ticketDetails)
    {
        // Include TCPDF library
        require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';

        // Create new PDF document
        $pdf = new TCPDF();
        $pdf->AddPage();

        // Set PDF metadata
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('Your Name');
        $pdf->SetTitle('Tickets');
        $pdf->SetSubject('Tickets for your purchase');
        $pdf->SetKeywords('TCPDF, PDF, ticket');

        // Set font
        $pdf->SetFont('helvetica', '', 12);

        // Add ticket content
        $html = '<h1>Tickets</h1>';
        foreach ($ticketDetails as $detail) {
            $html .= '<h2>Ticket</h2><table border="1" cellpadding="5">';
            foreach ($detail as $key => $value) {
                if ($key == 'qr_code_path') {
                    $html .= '<tr><td>' . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . '</td><td>';
                    if (!is_null($value)) {
                        $html .= '<img src="' . htmlspecialchars(__DIR__ . '/../public/images/qrCodes/' . $value, ENT_QUOTES, 'UTF-8') . '" />';
                    }
                    $html .= '</td></tr>';
                } else {
                    $html .= '<tr><td>' . htmlspecialchars($key, ENT_QUOTES, 'UTF-8') . '</td><td>';
                    if (!is_null($value)) {
                        $html .= htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
                    }
                    $html .= '</td></tr>';
                }
            }
            $html .= '</table><br />';
        }

        // Output the HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // Define the directory path for storing ticket PDFs
        $directoryPath = __DIR__ . '/../public/tickets/';

        // Check if the directory exists, if not, create it
        if (!is_dir($directoryPath)) {
            mkdir($directoryPath, 0777, true);
        }

        // Define the file path for the ticket PDF
        $pdfPath = $directoryPath . 'ticket_' . uniqid() . '.pdf';

        // Output PDF document to the defined path
        $pdf->Output($pdfPath, 'F');

        return $pdfPath;
    }

    private function sendTicketEmail($email, $name, $ticketPdf, $qrCodeImagePaths)
    {
        $mailConfig = require __DIR__ . '/../config/mail.php';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = $mailConfig['host'];
            $mail->SMTPAuth   = $mailConfig['SMTPAuth'];
            $mail->Username   = $mailConfig['username'];
            $mail->Password   = $mailConfig['password'];
            $mail->SMTPSecure = $mailConfig['SMTPSecure'];
            $mail->Port       = $mailConfig['port'];

            $mail->setFrom($mailConfig['from_email'], $mailConfig['from_name']);
            $mail->addAddress($email, $name);

            $mail->isHTML(true);
            $mail->Subject = 'Ticket Confirmation';

            // Body
            $body = '<p>Please find your tickets attached below with the QR codes:</p>';

            foreach ($qrCodeImagePaths as $i => $path) {
                $cid = 'qr' . $i;
                $mail->addEmbeddedImage($path, $cid);
                $body .= '<p>QR Code #' . ($i + 1) . ':</p>';
                $body .= "<img src='cid:$cid' style='width:200px;height:200px;'/><br/>";
                // Also attach QR image as separate file
                $mail->addAttachment($path);
            }

            $body .= '<p>The ticket PDF is attached as well.</p>';

            $mail->Body = $body;

            // Attach ticket PDF
            $mail->addAttachment($ticketPdf);

            $mail->send();
        } catch (Exception $e) {
            error_log("Ticket email could not be sent: {$mail->ErrorInfo}");
            var_dump($e->getMessage());
        }
    }

    public function getQR($orderId)
    {
        // Get all tickets for the order
       try {
          $tickets        = $this->orderService->getTicketsByOrderId($orderId);
        $qrCodeImagePaths = [];

        foreach ($tickets as $ticket) {
            // Generate a unique QR code for each ticket
            $qrCodeData = $ticket['qr_code'];

            // Create QR code builder with ticket data
            $qrCodeBuilder = Builder::create()
                ->writer(new PngWriter())
                ->data($qrCodeData)
                ->encoding(new Encoding('UTF-8'))
                ->errorCorrectionLevel(ErrorCorrectionLevel::High)
                ->size(300)
                ->margin(10)
                ->roundBlockSizeMode(RoundBlockSizeMode::Margin);

            // Generate QR code image in PNG format
            $qrCodeImage = $qrCodeBuilder->build();

            // Define the path to save the QR code image
            $qrCodeImagePath = __DIR__ . '/../public/images/qrCodes/' . $qrCodeData . '.png';

            // Save the QR code image to the specified path
            file_put_contents($qrCodeImagePath, $qrCodeImage->getString());

            // Add the path to the array
            $qrCodeImagePaths[] = $qrCodeImagePath;
        }

        return $qrCodeImagePaths;
       } catch (\Throwable $th) {
         throw $th;
       }
    }

    public function cancel()
    {
        Helper::setMessage(true, 'Payment was canceled.');
        header('Location: /personalprogram/basket');
        exit();
    }

    private function generateUniqueQrCode()
    {
        return bin2hex(random_bytes(16)); // Generate a secure QR code
    }

    public function scanQrCode($qrCode)
    {
        try {
            $this->orderService->updateTicketStatus($qrCode);
            Helper::setMessage(false, 'Ticket status updated successfully!');
            header('Location: /personalprogram/basket');
            exit();
        } catch (Exception $e) {
            $_SESSION['isError']       = 1;
            $_SESSION['flash_message'] = ($e->getMessage());

            $redirect = $_SERVER['HTTP_REFERER'] ?? '/login/login';
            header('Location: ' . $redirect);
        }
    }
    public function personalprogram()
    {
        try {
            $reservations = $this->basket->getAllItems();
            require __DIR__ . '/../views/frontend/PersonalProgram.php';
        } catch (Exception $ex) {
            $_SESSION['isError']       = 1;
            $_SESSION['flash_message'] = ($e->getMessage());

            $redirect = $_SERVER['HTTP_REFERER'] ?? '/login/login';
            header('Location: ' . $redirect);
        }
    }
}
