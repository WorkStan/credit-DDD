<?php

namespace App\Credit\Domain\Event\Client;

use App\Credit\Domain\Entity\Client\ClientId;
use App\Credit\Domain\Entity\Client\SSN;
use App\Shared\Infrastructure\Event\DefaultEvent;

final class ClientUpdatedSsnEvent extends DefaultEvent
{
    public function __construct(
        public readonly ClientId $clientId,
        public readonly SSN $oldSsn,
        public readonly SSN $newSsn
    ) {}
}
