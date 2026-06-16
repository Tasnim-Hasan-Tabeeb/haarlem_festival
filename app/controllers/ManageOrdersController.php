<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\View;
use App\Services\OrderService;
use Exception;

class ManageOrdersController extends Controller
{
    private OrderService $orderService;

    public function __construct() {
        $this->orderService = new OrderService();
    }

    /**
     * Summary of index
     */
    public function index() {
        try {
            $orders = $this->orderService->getAllOrders();
            return View::make('backend.orders.index', compact('orders'));
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    /**
     * Summary of exportOrdersToExcel
     */
    public function exportOrdersToExcel() {
        try {
             return $this->orderService->exportOrdersToExcel();
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }

    /**
     * Summary of exportOrdersToCSV
     */
    public function exportOrdersToCSV() {
        try {
             $this->orderService->exportOrdersToCSV();
        } catch (Exception $ex) {
            return $this->error($ex->getMessage());
        }
    }
}
