<?php

namespace App\Credit\Domain\Enum;

enum ProductStatus: string
{
    case New = 'new';
    case Review = 'review';
    case Available = 'available';
    case NotAvailable = 'not_available';
    case Issued = 'issued';
    case Repaid = 'repaid';

    /** @return string[] */
    public static function getAsArray(): array
    {
        return array_column(self::cases(), 'value');
    }
}
