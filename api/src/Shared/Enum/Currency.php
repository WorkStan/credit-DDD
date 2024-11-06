<?php

namespace App\Shared\Enum;

enum Currency: string
{
    case USD = 'USD';

    /** @return string[] */
    public static function getAsArray(): array
    {
        return array_column(self::cases(), 'name');
    }
}
