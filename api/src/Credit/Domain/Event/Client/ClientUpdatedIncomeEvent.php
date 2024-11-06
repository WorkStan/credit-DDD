<?php

namespace App\Credit\Domain\Event\Client;

use App\Credit\Domain\Entity\Client\ClientId;
use App\Shared\Entity\Embeddable\Money;
use App\Shared\Infrastructure\Event\DefaultEvent;

final class ClientUpdatedIncomeEvent extends DefaultEvent
{
    public function __construct(
        public readonly ClientId $clientId,
        public readonly Money $oldIncome,
        public readonly Money $newIncome
    ) {}
}
