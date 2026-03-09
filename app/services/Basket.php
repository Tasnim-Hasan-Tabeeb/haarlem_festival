<?php

namespace App\Services;

use App\Interfaces\BasketItemInterface;

class Basket
{
    public function addItem(BasketItemInterface $item)
    {
        if (!isset($_SESSION['basket'])) {
            $_SESSION['basket'] = [];
        }

        $itemArray = $item->toArray();
        $itemArray['cost'] = $item->getCost();

        $_SESSION['basket'][] = $itemArray;
    }

    public function getAllItems()
    {
        return $_SESSION['basket'] ?? [];
    }

    public function clearBasket()
    {
        $_SESSION['basket'] = [];
    }

    public function getTotalCost()
    {
        $totalCost = 0;
        foreach ($this->getAllItems() as $item) {
            $totalCost += $item['cost'];
        }
        return $totalCost;
    }

    public function removeItem($index)
    {
        if (isset($_SESSION['basket'][$index])) {
            unset($_SESSION['basket'][$index]);
            $_SESSION['basket'] = array_values($_SESSION['basket']); // Re-index array
        }
    }
}