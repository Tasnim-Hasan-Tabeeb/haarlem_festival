<?php

namespace App\Models;

enum TicketType:string
{
    case REGULAR = 'Regular';
    case FAMILY = 'Family';

    public static function getTicketType(self $value): string
    {
        return match ($value) {
            self::REGULAR => 'Regular',
            self::FAMILY => 'Family',
        };
    }
    public static function createFrom(string $value)
    {
        $value = ucfirst(strtolower($value));
        switch ($value) {
            case 'Regular':
                return TicketType::REGULAR;
            case 'Family':
                return TicketType::FAMILY;
            default:
                // Handle unknown values or throw an exception
                throw new \InvalidArgumentException("Invalid ticket type value: $value");
        }
    }

    public function toArray()
    {
        return [
            'ticket_type' => self::getTicketType($this),
        ];
    }
}
