<?php

namespace App\Credit\Domain\Event\Client;

use App\Credit\Domain\Entity\Client\ClientId;
use App\Credit\Domain\Entity\Client\FICO;
use App\Shared\Infrastructure\Event\DefaultEvent;

final class ClientUpdatedFicoEvent extends DefaultEvent
{
    public function __construct(
        public readonly ClientId $clientId,
        public readonly FICO $oldFico,
        public readonly FICO $newFico
    ) {}
}
