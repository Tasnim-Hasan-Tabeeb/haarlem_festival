<?php

namespace App\Models;

class Events{

    private ?int $event_id;
    private string $title;
    private string $event_type;
    private string $event_image;
    private string $description;
    private string $event_status;
    private string $event_start_date;
    private string $event_end_date;
    private string $primary_theme_color;
    private string $secondary_theme_color;

    public function __construct(
        ?int $event_id,
        string $event_type,
        string $title,
        string $event_image,
        string $description,
        string $event_status,
        string $event_start_date,
        string $event_end_date,
        string $primary_theme_color,
        string $secondary_theme_color
    ) {
        $this->event_id = $event_id;
        $this->event_type = $event_type;
        $this->title = $title;
        $this->event_image = $event_image;
        $this->description = $description;
        $this->event_status = $event_status;
        $this->event_start_date = $event_start_date;
        $this->event_end_date = $event_end_date;
        $this->primary_theme_color = $primary_theme_color;
        $this->secondary_theme_color = $secondary_theme_color;
    }

    public function getEventId(){
        return $this->event_id;
    }

    public function setEventId(int $event_id) {
        $this->event_id = $event_id;
    }

    public function getEventImage()
    {
        return $this->event_image;
    }

    public function setEventImage($event_image)
    {
        $this->event_image = $event_image;
    }
    public function getEventType()
    {
        return $this->event_type;
    }
    public function setEventType(string $event_type)
    {
        $this->event_type = $event_type;
    }
    public function getEventTitle()
    {
        return $this->title;
    }

    public function setEventTitle($title)
    {
        $this->title = $title;
    }

    public function getEventDescription()
    {
        return $this->description;
    }

    public function setEventDescription($description)
    {
        $this->description = $description;
    }

    public function getEventStatus()
    {
        return $this->event_status;
    }

    public function setEventStatus($event_status)
    {
        $this->event_status = $event_status;
    }

    public function getEventStartDate()
    {
        return $this->event_start_date;
    }

    public function setEventStartDate($event_start_date)
    {
        $this->event_start_date = $event_start_date;
    }

    public function getEventEndDate()
    {
        return $this->event_end_date;
    }

    public function setEventEndDate($event_end_date)
    {
        $this->event_end_date = $event_end_date;
    }

    public function getPrimaryThemeColor()
    {
        return $this->primary_theme_color;
    }

    public function setPrimaryThemeColor($primary_theme_color)
    {
        $this->primary_theme_color = $primary_theme_color;
    }

    public function getSecondaryThemeColor()
    {
        return $this->secondary_theme_color;
    }

    public function setSecondaryThemeColor($secondary_theme_color)
    {
        $this->secondary_theme_color = $secondary_theme_color;
    }

}