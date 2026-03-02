<?php

namespace App\Models;

use InvalidArgumentException;
use JsonSerializable;
use ReflectionClass;

class EventTypes implements jsonSerializable
{
    const Dance = 'Dance';
    const History = 'History';
    const Yummy = 'Yummy';

    private $value;
    public function __construct($value)
    {
        $this->value = $value;
    }
    public static function Dance(): self
    {
        return new self(self::Dance);
    }
    public static function History(): self
    {
        return new self(self::History);
    }
    public static function Yummy(): self
    {
        return new self(self::Yummy);
    }
    public static function getLabel(self $value): string
    {
        return match ($value->value) {
            self::Dance => 'Dance',
            self::History => 'History',
            self::Yummy => 'Customer',
            default => throw new InvalidArgumentException("Invalid status value: $value"),
        };
    }
    public static function fromString(string $value): self
    {
        return match ($value) {
            self::Administrator => self::Administrator(),
            self::History => self::History(),
            self::Yummy => self::Yummy(),
            default => throw new InvalidArgumentException("Invalid status value: $value"),
        };
    }

    public function jsonSerialize(): mixed
    {
        return $this->value;
    }
    public static function getEnumValues(): array
    {
        $reflectionClass = new ReflectionClass(__CLASS__);
        $constants = $reflectionClass->getConstants();
        return array_values($constants);
    }
}