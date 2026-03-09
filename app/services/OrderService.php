<?php

namespace App\Services;

use App\Models\Ticket;
use App\Repositories\OrderRepository;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class OrderService
{

    private $orderRepository;

    public function __construct()
    {
        $this->orderRepository = new OrderRepository();
    }

    public function getTicketWithQRCode($qrCode)
    {
        return $this->orderRepository->getTicketWithQRCode($qrCode);
    }

    public function updateTicketStatus($qrCode)
    {
        return $this->orderRepository->updateTicketStatus($qrCode);
    }
    
    public function createOrder($userId, $totalAmount)
    {
        return $this->orderRepository->createOrder($userId, $totalAmount);
    }
    
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
        $orders = $this->getAllOrders();
        $filename = "/path/to/export/orders.csv";
        $file = fopen($filename, 'w');

        // Add the header
        fputcsv($file, ['Order ID', 'Total Amount', 'Created At', 'Updated At', 'Item Type', 'Customer Name', 'Event Name']);

        // Add the data
        foreach ($orders as $order) {
            fputcsv($file, $order);
        }

        fclose($file);
        return $filename;
    }

    public function exportOrdersToExcel() {
        $orders = $this->getAllOrders();
        $filename = "orders.xlsx";

        // Using PhpSpreadsheet library
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add the header
        $header = ['Order ID', 'Total Amount', 'Created At', 'Updated At', 'Item Type', 'Customer Name', 'Event Name'];
        $sheet->fromArray($header, NULL, 'A1');

        // Add the data
        $sheet->fromArray($orders, NULL, 'A2');

        $writer = new Xlsx($spreadsheet);
        $writer->save($filename);

        return $filename;
    }
}
