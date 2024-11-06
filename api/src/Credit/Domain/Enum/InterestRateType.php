<?php

namespace App\Credit\Domain\Enum;

enum InterestRateType: string
{
    case Add = 'add';
    case Sub = 'sub';
}
