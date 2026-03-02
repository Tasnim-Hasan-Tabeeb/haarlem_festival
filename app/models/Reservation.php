<?php

namespace App\Models;

use App\Interfaces\BasketItemInterface;

class Reservation implements BasketItemInterface
{
    private $reservation_id;
    private $name;
    private $reservation_date;
    private $total_adult;
    private $total_children;
    private $email;
    private $phone;
    private $user_id;
    private $session_id;
    private $restaurant_id;
    private $remarks;
    private $cost_per_person;
    private $is_active;
    private $created_at;
    private $updated_at;
    private $total_cost;
    private $payment_status;
    private $confirmation_code;

    public function __construct($name, $reservation_date, $total_adult, $total_children, $email, $phone, $user_id, $session_id, $restaurant_id, $remarks, $cost_per_person)
    {
        $this->name = $name;
        $this->reservation_date = $reservation_date;
        $this->total_adult = $total_adult;
        $this->total_children = $total_children;
        $this->email = $email;
        $this->phone = $phone;
        $this->user_id = $user_id;
        $this->session_id = $session_id;
        $this->restaurant_id = $restaurant_id;
        $this->remarks = $remarks;
        $this->cost_per_person = $cost_per_person;
        $this->total_cost = $this->calculateTotalCost();
        $this->is_active = 1;
        $this->payment_status = 'pending';
        $this->confirmation_code = $this->generateConfirmationCode();
    }

    public function getReservationId()
    {
        return $this->reservation_id;
    }
    
    public function setReservationId($reservation_id)
    {
        $this->reservation_id = $reservation_id;
    }

    public function getUserId()
    {
        return $this->user_id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getReservationDate()
    {
        return $this->reservation_date;
    }

    public function getTotalAdult()
    {
        return $this->total_adult;
    }

    public function getTotalChildren()
    {
        return $this->total_children;
    }

    public function getEmail()
    {
        return $this->email;
    }
    
    public function getPhone()
    {
        return $this->phone;
    }

    public function getSessionId()
    {
        return $this->session_id;
    }

    public function getRestaurantId()
    {
        return $this->restaurant_id;
    }

    public function getRemarks()
    {
        return $this->remarks;
    }

    public function getCost()
    {
        return $this->total_cost;
    }

    public function getPaymentStatus()
    {
        return $this->payment_status;
    }
    
    public function setPaymentStatus($payment_status)
    {
        $this->payment_status = $payment_status;
    }

    public function getConfirmationCode()
    {
        return $this->confirmation_code;
    }

    private function calculateTotalCost()
    {
        return $this->cost_per_person * ($this->total_adult + $this->total_children);
    }

    private function generateConfirmationCode()
    {
        return strtoupper(uniqid('CONF-'));
    }

    public function toArray()
    {
        return [
            'name' => $this->name,
            'reservation_date' => $this->reservation_date,
            'total_adult' => $this->total_adult,
            'total_children' => $this->total_children,
            'email' => $this->email,
            'phone' => $this->phone,
            'session_id' => $this->session_id,
            'user_id' => $this->user_id,
            'restaurant_id' => $this->restaurant_id,
            'remarks' => $this->remarks,
            'cost_per_person' => $this->cost_per_person,
            'is_active' => $this->is_active,
            'total_cost' => $this->total_cost,
            'payment_status' => $this->payment_status,
            'confirmation_code' => $this->confirmation_code,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}