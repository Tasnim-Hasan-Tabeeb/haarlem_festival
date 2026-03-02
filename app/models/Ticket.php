<?php

namespace App\Models;

class Ticket
{
    private $customerName;
    private $eventName;
    private $eventDate;
    private $eventTime;
    private $qrCode;
    private $status;

    public function __construct($customerName, $eventName, $eventDate, $eventTime, $qrCode, $status = 'new')
    {
        $this->customerName = $customerName;
        $this->eventName = $eventName;
        $this->eventDate = $eventDate;
        $this->eventTime = $eventTime;
        $this->qrCode = $qrCode;
        $this->status = $status;
    }

    public function getCustomerName()
    {
        return $this->customerName;
    }

    public function getEventName()
    {
        return $this->eventName;
    }

    public function getEventDate()
    {
        return $this->eventDate;
    }

    public function getEventTime()
    {
        return $this->eventTime;
    }

    public function getQrCode()
    {
        return $this->qrCode;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function toArray()
    {
        return [
            'customerName' => $this->customerName,
            'eventName' => $this->eventName,
            'eventDate' => $this->eventDate,
            'eventTime' => $this->eventTime,
            'qrCode' => $this->qrCode,
            'status' => $this->status,
        ];
    }
}