<?php

namespace App\Credit\Domain\Event\Client;

use App\Credit\Domain\Entity\Client\ClientId;
use App\Shared\Infrastructure\Event\DefaultEvent;

final class ClientCreatedEvent extends DefaultEvent
{
    public function __construct(
        public readonly ClientId $clientId
    ) {}
}
