<?php

namespace App\Credit\Domain\Event\Client;

use App\Credit\Domain\Entity\Client\Address;
use App\Credit\Domain\Entity\Client\ClientId;
use App\Shared\Infrastructure\Event\DefaultEvent;

final class ClientUpdatedAddressEvent extends DefaultEvent
{
    public function __construct(
        public readonly ClientId $clientId,
        public readonly Address $oldAddress,
        public readonly Address $newAddress
    ) {}
}
