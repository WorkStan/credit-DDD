<?php

namespace App\Credit\Domain\Event\Client;

use App\Credit\Domain\Entity\Client\ClientId;
use App\Shared\Infrastructure\Event\DefaultEvent;
use App\Shared\ValueObject\PhoneNumber;

final class ClientUpdatedPhoneNumberEvent extends DefaultEvent
{
    public function __construct(
        public readonly ClientId $clientId,
        public readonly PhoneNumber $oldPhoneNumber,
        public readonly PhoneNumber $newPhoneNumber
    ) {}
}
