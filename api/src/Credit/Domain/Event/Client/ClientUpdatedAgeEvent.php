<?php

namespace App\Credit\Domain\Event\Client;

use App\Credit\Domain\Entity\Client\Age;
use App\Credit\Domain\Entity\Client\ClientId;
use App\Shared\Infrastructure\Event\DefaultEvent;

final class ClientUpdatedAgeEvent extends DefaultEvent
{
    public function __construct(
        public readonly ClientId $clientId,
        public readonly Age $oldAge,
        public readonly Age $newAge
    ) {}
}
