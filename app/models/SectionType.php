<?php

namespace App\Models;

enum SectionType:string
{
    case Header = 'Header';
    case Introduction = 'Introduction';
    case Information  = 'Information';
    case RegularTicket = 'RegularTicket';
    case FamilyTicket = 'FamilyTicket';
    case Routes = 'Routes';
    public static function getSectionType(self $value): string
    {
        return match ($value) {
            self::Header => 'Header',
            self::Introduction => 'Introduction',
            self::Information => 'Information',
            self::RegularTicket => 'RegularTicket',
            self::FamilyTicket => 'FamilyTicket',
            self::Routes => 'Routes',
        };
    }
    public static function createFrom(string $value): SectionType
    {
        $value = ucfirst(strtolower($value));
        switch ($value) {
            case 'Header':
                return SectionType::Header;
            case 'Introduction':
                return SectionType::Introduction;
            case 'Information':
                return SectionType::Information;
            case 'RegularTicket':
                return SectionType::RegularTicket;
            case 'FamilyTicket':
                return SectionType::FamilyTicket;
            case 'Routes':
                return SectionType::Routes;
            default:
                // Handle unknown values or throw an exception
                throw new \InvalidArgumentException("Invalid section type value: $value");
        }
    }
}
