<?php

namespace App\Credit\Domain\Enum;

enum InterestRateKey: string
{
    case Default = 'default';
    case California = 'california_additional';
}
