<?php

namespace App\Models;

use App\Interfaces\BasketItemInterface;
use DateTime;

class HistoryTicket implements BasketItemInterface
{
    private int $history_ticket_id;
    private TicketType $ticketType;
    private float $price;
    private string $start_location;
    private string $timeslot;
    private int $participants;

    public function __construct(
        TicketType $ticketType,
        float $price,
        string $start_location,
        string $timeslot,
        int $participants
    )
    {
        $this->ticketType = $ticketType;
        $this->price = $price;
        $this->start_location = $start_location;
        $this->timeslot = $timeslot;
        $this->participants = $participants;
    }
    public function getHistoryTicketId(): int
    {
        return $this->history_ticket_id;
    }
    public function setHistoryTicketId(int $history_ticket_id): void
    {
        $this->history_ticket_id = $history_ticket_id;
    }
    public function getTicketType(): TicketType
    {
        return $this->ticketType;
    }
    public function setTicketType(TicketType $ticketType): void
    {
        $this->ticketType = $ticketType;
    }
    public function getPrice(): float
    {
        return $this->price;
    }
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
    public function getStartLocation(): string
    {
        return $this->start_location;
    }
    public function setStartLocation(string $start_location): void
    {
        $this->start_location = $start_location;
    }
    public function getTimeslot(): string
    {
        return $this->timeslot;
    }
    public function setTimeslot(string $timeslot): void
    {
        $this->timeslot = $timeslot;
    }
    public function toArray()
    {
        return [
            'participants'=> $this->participants,
            'ticketType' => $this->ticketType->toArray(),
            'price' => $this->price,
            'start_location' => $this->start_location,
            'timeslot' => $this->timeslot
        ];
    }

    public function getCost()
    {
        return $this->price;
    }
}