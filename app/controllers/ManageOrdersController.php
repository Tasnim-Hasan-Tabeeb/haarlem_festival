<?php

namespace App\Controllers;

use App\Services\OrderService;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ManageOrdersController
{
    private $orderService;

    public function __construct() {
        $this->orderService = new OrderService();
    }

    public function index() {
        $orders = $this->orderService->getAllOrders();
        require '../views/backend/orders/index.php';
    }

    public function exportOrdersToExcel() {
        $orders = $this->orderService->getAllOrders(); // Adjust to your actual method
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Add headers
        $header = ['Order ID', 'Total Amount', 'Created At', 'Updated At', 'Item Type', 'Customer Name', 'Event Name'];
        $sheet->fromArray($header, NULL, 'A1');

        // Add data
        $rowNumber = 2;
        foreach ($orders as $order) {
            $sheet->setCellValue('A' . $rowNumber, $order['order_id']);
            $sheet->setCellValue('B' . $rowNumber, $order['total_amount']);
            $sheet->setCellValue('C' . $rowNumber, $order['created_at']);
            $sheet->setCellValue('D' . $rowNumber, $order['updated_at']);
            $sheet->setCellValue('E' . $rowNumber, $order['item_type']);
            $sheet->setCellValue('F' . $rowNumber, $order['customer_name']);
            $sheet->setCellValue('G' . $rowNumber, $order['event_name']);
            $rowNumber++;
        }

        // Headers for browser download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="orders.xlsx"');
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function exportOrdersToCSV() {
        $orders = $this->orderService->getAllOrders(); // Adjust to your actual method
        $filename = "orders_" . date('Ymd') . ".csv";

        // Set headers
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        header('Cache-Control: no-cache, no-store, must-revalidate');
        header('Pragma: no-cache');
        header('Expires: 0');

        // Open output stream
        $output = fopen('php://output', 'w');

        // Output column headers
        fputcsv($output, ['Order ID', 'Total Amount', 'Created At', 'Updated At', 'Item Type', 'Customer Name', 'Event Name']);

        // Output data rows
        foreach ($orders as $order) {
            fputcsv($output, [
                $order['order_id'],
                $order['total_amount'],
                $order['created_at'],
                $order['updated_at'],
                $order['item_type'],
                $order['customer_name'],
                $order['event_name']
            ]);
        }

        fclose($output);
        exit;
    }

}