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

    public function getAllOrders()
    {
        return $this->orderRepository->getOrders();
    }
}
