<?php

namespace Core\Controllers;

class RestaurantController extends BaseController
{
    public function pageView()
    {
        $title = "Restaurants in Haarlem";

        $restaurants = [
            ["name" => "Ratatouille Food & Wine", "type" => "Fine dining", "price" => "€€€", "rating" => 4.7],
            ["name" => "DeDAKKAS", "type" => "Rooftop & seasonal", "price" => "€€", "rating" => 4.6],
            ["name" => "Spaarne66", "type" => "Dutch & European", "price" => "€€", "rating" => 4.5],
            ["name" => "Brick", "type" => "Pizza & Italian", "price" => "€€", "rating" => 4.4],
            ["name" => "The Governor", "type" => "Burgers & steaks", "price" => "€€", "rating" => 4.3],
            ["name" => "Mogador", "type" => "Moroccan", "price" => "€€", "rating" => 4.4],
        ];
        $this->view('restaurant', compact('title', 'restaurants'));
    }
}
