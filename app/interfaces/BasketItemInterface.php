<?php

namespace App\Interfaces;

interface BasketItemInterface
{
    public function toArray();
    public function getCost();
}
