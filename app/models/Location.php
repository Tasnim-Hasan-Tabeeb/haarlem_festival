<?php
namespace App\Models;
class Location{
    public ?int $tour_location_id;
    public string $location_name;
    public string $description;
    public string $address;
    public string $contact_info;
    public string $image_url;
public function __construct(?int $tour_location_id, string $location_name, string $description, string $address, string $contact_info, string $image_url)
    {
        $this->tour_location_id = $tour_location_id;
        $this->location_name = $location_name;
        $this->description = $description;
        $this->address = $address;
        $this->contact_info = $contact_info;
        $this->image_url = $image_url;
    }
    public function getTour_location_id(): int
    {
        return $this->tour_location_id;
    }
    public function setTour_location_id(int $tour_location_id): void
    {
        $this->tour_location_id = $tour_location_id;
    }
    public function getLocation_name(): string
    {
        return $this->location_name;
    }
    public function setLocation_name(string $location_name): void
    {
        $this->location_name = $location_name;
    }
    public function getDescription(): string
    {
        return $this->description;
    }
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }
    public function getAddress(): string
    {
        return $this->address;
    }
    public function setAddress(string $address): void
    {
        $this->address = $address;
    }
    public function getContact_info(): string
    {
        return $this->contact_info;
    }
    public function setContact_info(string $contact_info): void
    {
        $this->contact_info = $contact_info;
    }
public function getImage_url(): string
    {
        return $this->image_url;
    }
    public function setImage_url(string $image_url): void
    {
        $this->image_url = $image_url;
    }

}