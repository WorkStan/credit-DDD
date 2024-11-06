<?php

namespace App\Credit\Domain\Event\Client;

use App\Credit\Domain\Entity\Client\ClientId;
use App\Shared\Infrastructure\Event\DefaultEvent;
use App\Shared\ValueObject\Email;

final class ClientUpdatedEmailEvent extends DefaultEvent
{
    public function __construct(
        public readonly ClientId $clientId,
        public readonly Email $oldEmail,
        public readonly Email $newEmail
    ) {}
}
