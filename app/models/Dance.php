<?php

namespace App\Models;

use App\Interfaces\BasketItemInterface;

class Dance implements BasketItemInterface
{
    private int $music_performance_id;
    private int $music_event_id;
    private int $event_id;
    private int $event_price;
    private string $session_type;
    private string $start_date;
    private string $event_start_time;
    private int $event_duration;
    private string $title;
private int $quantity;

    public function __construct(
        int $music_performance_id,
        int $music_event_id,
        int $event_price,
        string $session_type,
        string $start_date,
        string $event_start_time,
        int $event_duration,
        string $title,
        int $event_id,
        int $quantity,
    ) {
        $this->music_performance_id = $music_performance_id;
        $this->music_event_id = $music_event_id;
        $this->event_price = $event_price;
        $this->session_type = $session_type;
        $this->start_date = $start_date;
        $this->event_start_time = $event_start_time;
        $this->event_duration = $event_duration;
        $this->title = $title;
        $this->event_id = $event_id;
        $this->quantity = $quantity;
    }

    public function getMusicPerformanceId(): int
    {
        return $this->music_performance_id;
    }
    public function getMusicEventId(): int
    {
        return $this->music_event_id;
    }
    public function getEventPrice(): int
    {
        return $this->event_price;
    }
    public function getSessionType(): string
    {
        return $this->session_type;
    }
    public function getStartDate(): string
    {
        return $this->start_date;
    }
    public function getEventStartTime(): string
    {
        return $this->event_start_time;
    }
    public function getEventDuration(): int
    {
        return $this->event_duration;
    }
    public function getTitle(): string
    {
        return $this->title;
    }

    public function getEventId(): int
    {
        return $this->event_id;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function setMusicPerformanceId(int $music_performance_id): void
    {
        $this->music_performance_id = $music_performance_id;
    }
    public function setMusicEventId(int $music_event_id): void
    {
        $this->music_event_id = $music_event_id;
    }
    public function setEventPrice(int $event_price): void
    {
        $this->event_price = $event_price;
    }
    public function setSessionType(string $session_type): void
    {
        $this->session_type = $session_type;
    }
    public function setStartDate(string $start_date): void
    {
        $this->start_date = $start_date;
    }
    public function setEventStartTime(string $event_start_time): void
    {
        $this->event_start_time = $event_start_time;
    }
    public function setEventDuration(int $event_duration): void
    {
        $this->event_duration = $event_duration;
    }
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }
    public function setEventId(int $event_id): void
    {
        $this->event_id = $event_id;
    }
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    public function toArray()
    {
        return [
            'music_performance_id' => $this->music_performance_id,
            'music_event_id' => $this->music_event_id,
            'event_price' => $this->event_price,
            'session_type' => $this->session_type,
            'event_date' => $this->start_date,
            'event_start_time' => $this->event_start_time,
            'event_duration' => $this->event_duration,
            'event_id' => $this->event_id,
            'event_name' => $this->title,
            'quantity' => $this->quantity,
        ];
    }

    public function getCost()
    {
        return $this->event_price;
    }
}
