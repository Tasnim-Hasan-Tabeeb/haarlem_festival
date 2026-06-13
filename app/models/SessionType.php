<?php

namespace App\Models;

use JsonSerializable;

class SessionType implements jsonSerializable
{
    const CLUB        = 'Club';
    const BACK2BACK   = 'Back2Back';
    const TIESTOWORLD = 'TiëstoWorld';

    public static function getAll()
    {
        return [
            self::CLUB,
            self::BACK2BACK,
            self::TIESTOWORLD,
        ];
    }
    public function jsonSerialize(): mixed
    {
        return $this->value;
    }
}
