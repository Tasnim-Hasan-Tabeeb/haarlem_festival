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

        $itemArray         = $item->toArray();
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
            $totalCost += $this->calculateItemTotal($item);
        }
        return $totalCost;
    }

    public function calculateItemTotal(array $item): float
    {
        if (isset($item['reservation_date'])) {
            $adults = (int) ($item['total_adult'] ?? 0);
            $children = (int) ($item['total_children'] ?? 0);
            $costPerPerson = (float) ($item['cost_per_person'] ?? 0);

            return $costPerPerson * ($adults + $children);
        }

        if (isset($item['music_performance_id'])) {
            $unitPrice = (float) ($item['event_price'] ?? 0);
            $quantity = max(1, (int) ($item['quantity'] ?? 1));

            return $unitPrice * $quantity;
        }

        if (isset($item['passType'])) {
            $unitPrice = (float) ($item['passPrice'] ?? $item['cost'] ?? 0);
            $quantity = max(1, (int) ($item['quantity'] ?? 1));

            return $unitPrice * $quantity;
        }

        return (float) ($item['cost'] ?? 0);
    }

    public function removeItem($index)
    {
        if (isset($_SESSION['basket'][$index])) {
            unset($_SESSION['basket'][$index]);
            $_SESSION['basket'] = array_values($_SESSION['basket']); // Re-index array
        }
    }

    public function updateItemQuantity(int $index, int $quantity): array
    {
        if (!isset($_SESSION['basket'][$index])) {
            throw new \InvalidArgumentException('Basket item not found.');
        }

        if ($quantity < 1) {
            throw new \InvalidArgumentException('Quantity must be at least 1.');
        }

        if (isset($_SESSION['basket'][$index]['quantity'])) {
            $_SESSION['basket'][$index]['quantity'] = $quantity;

            return $_SESSION['basket'][$index];
        }

        $ticketType = $_SESSION['basket'][$index]['ticketType']['ticket_type'] ?? null;
        if ($ticketType !== null) {
            $currentParticipants = max(1, (int) ($_SESSION['basket'][$index]['participants'] ?? 1));
            $currentTotal = (float) ($_SESSION['basket'][$index]['price'] ?? $_SESSION['basket'][$index]['cost'] ?? 0);
            $unitPrice = $currentTotal / $currentParticipants;

            $_SESSION['basket'][$index]['participants'] = $quantity;
            $_SESSION['basket'][$index]['price'] = $unitPrice * $quantity;
            $_SESSION['basket'][$index]['cost'] = $unitPrice * $quantity;

            return $_SESSION['basket'][$index];
        }

        throw new \InvalidArgumentException('This item quantity cannot be adjusted here.');
    }
}
