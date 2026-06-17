<?php

namespace App\Services;

use App\Helpers\Helper;
use App\Models\Reservation;
use App\Models\Ticket;
use App\Repositories\OrderRepository;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Stripe\Checkout\Session;
use Stripe\Stripe;

use TCPDF;

class OrderService
{
    private OrderRepository $orderRepository;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
    }

    /**
     * Summary of getTicketWithQRCode
     * @param mixed $qrCode
     */
    public function getTicketWithQRCode($qrCode)
    {
        return $this->orderRepository->getTicketWithQRCode($qrCode);
    }

    /**
     * Summary of updateTicketStatus
     * @param mixed $qrCode
     * @return bool
     */
    public function updateTicketStatus($qrCode)
    {
        return $this->orderRepository->updateTicketStatus($qrCode);
    }

    /**
     * Summary of createOrder
     * @param mixed $userId
     * @param mixed $totalAmount
     * @return bool|string
     */
    public function createOrder($userId, $totalAmount)
    {
        return $this->orderRepository->createOrder($userId, $totalAmount);
    }

    /**
     * Summary of addOrderItem
     * @param mixed $orderId
     * @param mixed $itemType
     * @param mixed $itemId
     * @return void
     */
    public function addOrderItem($orderId, $itemType, $itemId): void
    {
        $this->orderRepository->addOrderItem($orderId, $itemType, $itemId);
    }

    public function createTicket(Ticket $ticket)
    {
        return $this->orderRepository->createTicket($ticket);
    }

    public function getTicketsByOrderId(int $orderId)
    {
        return $this->orderRepository->getTicketsByOrderId($orderId);
    }
    public function getAllOrders()
    {
        return $this->orderRepository->getOrders();
    }
    public function exportOrdersToCSV() {
        $orders   = $this->getAllOrders();
        $filename = 'orders_' . date('Ymd') . '.csv';

        // Set headers
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Open output stream
        $output = fopen('php://output', 'w');

        // Output column headers
        fputcsv($output, [
                         'Order ID',
                         'Total Amount',
                         'Payment Status',
                         'Created At',
                         'Updated At',
                         'Item Type',
                         'Customer Name',
                         'Customer Email',
                         'Event Date',
                         'Event Time'
                        ]);

        // Output data rows
        foreach ($orders as $order) {
            fputcsv($output, [
                $order['order_id'],
                $order['total_amount'],
                $order['payment_status'],
                $order['created_at'],
                $order['updated_at'],
                $order['item_type'],
                $order['customer_name'],
                $order['email'],
                $order['event_date'],
                $order['event_time'],
            ]);
        }

        fclose($output);
        exit;
    }

    public function exportOrdersToExcel() {
        $orders      = $this->getAllOrders();
        $spreadsheet = new Spreadsheet();
        $sheet       = $spreadsheet->getActiveSheet();

        $header = [
                         'Order ID',
                         'Total Amount',
                         'Payment Status',
                         'Created At',
                         'Updated At',
                         'Item Type',
                         'Customer Name',
                         'Customer Email',
                         'Event Date',
                         'Event Time'
        ];
        $sheet->fromArray($header, NULL, 'A1');

        $rowNumber = 2;

        foreach ($orders as $order) {
            $sheet->setCellValue('A' . $rowNumber, $order['order_id']);
            $sheet->setCellValue('B' . $rowNumber, $order['total_amount']);
            $sheet->setCellValue('C' . $rowNumber, $order['payment_status']);
            $sheet->setCellValue('D' . $rowNumber, $order['created_at']);
            $sheet->setCellValue('E' . $rowNumber, $order['updated_at']);
            $sheet->setCellValue('F' . $rowNumber, $order['item_type']);
            $sheet->setCellValue('G' . $rowNumber, $order['customer_name']);
            $sheet->setCellValue('H' . $rowNumber, $order['email']);
            $sheet->setCellValue('I' . $rowNumber, $order['event_date']);
            $sheet->setCellValue('K' . $rowNumber, $order['event_time']);
            $rowNumber++;
        }

        // Clean output buffer (VERY IMPORTANT)
        if (ob_get_length()) {
            ob_end_clean();
        }

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="orders.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    /**
     * Summary of createCheckoutSession
     * @param mixed $cartItems
     * @param mixed $user
     * @return Session
     */
    public function createCheckoutSession($cartItems, $user){
        $key         = Helper::getStripeApiKey();
        $lineItems   = [];
        $totalAmount = 0;

        foreach ($cartItems as $cartItem) {
            if(isset($cartItem['ticketType']) && isset($cartItem['ticketType']['ticket_type']) && $cartItem['ticketType']['ticket_type'] == 'Regular')
            {
                $cartItem['cost_per_person'] = $cartItem['cost'] / $cartItem['participants'];
            }

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

        $taxAmount          = $totalAmount * 0.09;
        $totalAmountWithTax = $totalAmount + $taxAmount;

        $lineItems[] = [
            'price_data' => [
                'currency'     => 'eur',
                'product_data' => [
                    'name' => 'Tax (9%)',
                ],
                'unit_amount' => (int) round($taxAmount * 100),
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
            'success_url' => 'http://localhost/personalprogram/checkoutSuccess?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url'  => 'http://localhost/personalprogram/checkoutCancel',
        ]);

        return $session;
    }

    /**
     * Summary of getQR
     * @param mixed $orderId
     * @return string[]
     */
    public function getQR($orderId)
    {
        $tickets          = $this->getTicketsByOrderId($orderId);
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
    }

    /**
     * Summary of handleSuccessCheckout
     * @param mixed $cartItems
     * @param mixed $session
     * @param mixed $reservationService
     * @return void
     */
    public function handleSuccessCheckout($cartItems, $session, $reservationService)
    {
            $totalAmount = 0;

            foreach ($cartItems as $cartItem) {
                $totalAmount += isset($cartItem['cost_per_person']) ? $cartItem['cost_per_person'] * ($cartItem['total_adult'] + $cartItem['total_children']) : $cartItem['cost'];
            }

            $userId = $session->client_reference_id;

            $name  = $session->metadata->name;
            $email = $session->metadata->user_email;

            $orderId = $this->createOrder($userId, $totalAmount);

            $ticketDetails  = [];
            $invoiceDetails = [];

            foreach ($cartItems as $cartItem) {
                if (isset($cartItem['reservation_date'])) {
                    $reservation = new Reservation(
                        $name,
                        $cartItem['reservation_date'],
                        $cartItem['total_adult'],
                        $cartItem['total_children'],
                        $email,
                        $cartItem['phone'],
                        $userId,
                        $cartItem['session_id'],
                        $cartItem['restaurant_id'],
                        $cartItem['remarks'],
                        $cartItem['cost_per_person']
                    );

                    $reservation->setPaymentStatus('completed');
                    $reservationId = $reservationService->createReservation($reservation);
                    $this->addOrderItem($orderId, 'reservation', $reservationId);

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

                    $ticketId = $this->createTicket($ticket);

                    $this->addOrderItem($orderId, 'history_ticket', $ticketId);

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

                    $ticketId = $this->createTicket($ticket);
                    $this->addOrderItem($orderId, 'dance_pass', $ticketId);

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

                    $ticketId = $this->createTicket($ticket);
                    $this->addOrderItem($orderId, 'dance_ticket', $ticketId);

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

            $qrCodeImagePaths = $this->getQR($orderId);
            $ticketPdf        = $this->generateTicketPdf($ticketDetails);

            if($ticketPdf && is_array($qrCodeImagePaths) && count( $qrCodeImagePaths) != 0 ) {
                $this->sendTicketEmail($email, $name, $ticketPdf, $qrCodeImagePaths);
            }
    }

    /**
     * Summary of generateInvoicePdf
     * @param mixed $invoiceDetails
     * @return string
     */
    private function generateInvoicePdf($invoiceDetails)
    {
        require_once __DIR__ . '/../vendor/tecnickcom/tcpdf/tcpdf.php';

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
                    <td>' . htmlspecialchars(round($detail['price'], 2), ENT_QUOTES, 'UTF-8') . ' EUR</td>
                    <td>' . htmlspecialchars(round($detail['total_cost'], 2), ENT_QUOTES, 'UTF-8') . ' EUR</td>
                  </tr>';
        }

        $taxAmount    = $totalAmount * 0.09;
        $totalWithTax = $totalAmount + $taxAmount;

        $html .= '<tr>
                <td colspan="4" style="text-align: right;"><strong>Subtotal</strong></td>
                <td>' . htmlspecialchars(round($totalAmount, 2), ENT_QUOTES, 'UTF-8') . ' EUR</td>
              </tr>';
        $html .= '<tr>
                <td colspan="4" style="text-align: right;"><strong>Tax (9%)</strong></td>
                <td>' . htmlspecialchars(round($taxAmount, 2), ENT_QUOTES, 'UTF-8') . ' EUR</td>
              </tr>';
        $html .= '<tr>
                <td colspan="4" style="text-align: right;"><strong>Total Amount</strong></td>
                <td>' . htmlspecialchars(round($totalWithTax, 2), ENT_QUOTES, 'UTF-8') . ' EUR</td>
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

    /**
     * Summary of sendInvoiceEmail
     * @param mixed $email
     * @param mixed $name
     * @param mixed $invoicePdf
     * @return void
     */
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

    /**
     * Summary of generateTicketPdf
     * @param mixed $ticketDetails
     * @return string
     */
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

    /**
     * Summary of sendTicketEmail
     * @param mixed $email
     * @param mixed $name
     * @param mixed $ticketPdf
     * @param mixed $qrCodeImagePaths
     * @return void
     */
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
        }
    }

    private function generateUniqueQrCode()
    {
        return bin2hex(random_bytes(16));
    }
}
