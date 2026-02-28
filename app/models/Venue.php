<?php

namespace App\Models;
class Venue{

    public ?int $venue_id;
    public string $venue_name;
    public string $venue_location;
    public int $capacity;
    public string $venue_image;
    public string $map_url;


    public function __construct(?int $venue_id, string $venue_name, string $venue_location, int $capacity, string $venue_image, string $map)
    {
        $this->venue_id = $venue_id;
        $this->venue_name = $venue_name;
        $this->venue_location = $venue_location;
        $this->capacity = $capacity;
        $this->venue_image = $venue_image;
        $this->map_url = $map;
    }
    public function getVenue_id(): int
    {
        return $this->venue_id;
    }
    public function setVenue_id(int $venue_id): void
    {
        $this->venue_id = $venue_id;
    }
    public function getVenue_name(): string
    {
        return $this->venue_name;
    }
    public function setVenue_name(string $venue_name): void
    {
        $this->venue_name = $venue_name;
    }

    public function getMap_url(): string
    {
        return $this->map_url;
    }

    public function setMap_url(string $map_url): void
    {
        $this->map_url = $map_url;
    }
    public function getVenue_location(): string
    {
        return $this->venue_location;
    }
    public function setVenue_location(string $venue_location): void
    {
        $this->venue_location = $venue_location;
    }
    public function getCapacity(): int
    {
        return $this->capacity;
    }
    public function setCapacity(int $capacity): void
    {
        $this->capacity = $capacity;
    }
    public function getVenue_image(): string
    {
        return $this->venue_image;
    }
    public function setVenue_image(string $venue_image): void
    {
        $this->venue_image = $venue_image;
    }
}