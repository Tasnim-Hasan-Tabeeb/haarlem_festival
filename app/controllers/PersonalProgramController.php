<?php

namespace App\Controllers;

use App\Controllers\Core\Controller;
use App\Helpers\Helper;
use App\Helpers\View;
use App\Services\Basket;
use App\Services\OrderService;
use App\Services\ReservationService;
use Exception;
use Stripe\Checkout\Session;

use Stripe\Stripe;
class PersonalProgramController extends Controller
{
    private ReservationService $reservationService;
    private OrderService $orderService;
    private Basket $basket;

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
            return View::make('frontend.basket', compact('cartItems'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Summary of removeItem
     */
    public function removeItem()
    {
        try {
            $index = $_GET['index'];
            $this->basket->removeItem($index);
            return $this->redirect('/personalprogram/basket');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Summary of checkout
     */
    public function checkout()
    {
        try {
            if (!isset($_SESSION['user'])) {
                return $this->error('You must be logged in to checkout', '/personalprogram/basket');
            }
            $user      = $_SESSION['user'];
            $cartItems = $this->basket->getAllItems();
            $session   = $this->orderService->createCheckoutSession($cartItems, $user);
            return $this->redirect($session->url);
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Summary of checkoutSuccess
     */
    public function checkoutSuccess()
    {
        try {
            $sessionId = $_GET['session_id'];
            Stripe::setApiKey(Helper::getStripeApiKey());
            $session = Session::retrieve($sessionId);

            if ($session->payment_status === 'paid') {
                $cartItems = $this->basket->getAllItems();
                $this->orderService->handleSuccessCheckout($cartItems, $session, $this->reservationService);
                $this->basket->clearBasket();
                return $this->success('Reservations and tickets confirmed and stored successfully!', '/personalprogram/basket');
            }

            return $this->error('Payment was not successful.', '/personalprogram/basket');
        } catch (Exception $e) {
            return $this->error($e->getMessage(), '/personalprogram/basket');
        }
    }

    /**
     * Summary of checkoutCancel
     */
    public function checkoutCancel()
    {
        return $this->error('Payment was canceled.', '/personalprogram/basket');
    }

    /**
     * Summary of scanQrCode
     * @param mixed $qrCode
     */
    public function scanQrCode($qrCode)
    {
        try {
            $this->orderService->updateTicketStatus($qrCode);
            return $this->success('Ticket status updated successfully!', '/personalprogram/basket');
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }

    /**
     * Summary of personalprogram
     */
    public function personalprogram()
    {
        try {
            $reservations = $this->basket->getAllItems();
            return View::make('frontend.PersonalProgram', compact('reservations'));
        } catch (Exception $e) {
            return $this->error($e->getMessage());
        }
    }
}
