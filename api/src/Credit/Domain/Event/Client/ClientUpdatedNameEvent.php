<?php

namespace App\Credit\Domain\Event\Client;

use App\Credit\Domain\Entity\Client\ClientId;
use App\Credit\Domain\Entity\Client\ClientName;
use App\Shared\Infrastructure\Event\DefaultEvent;

final class ClientUpdatedNameEvent extends DefaultEvent
{
    public function __construct(
        public readonly ClientId   $clientId,
        public readonly ClientName $oldName,
        public readonly ClientName $newName
    ) {}
}
