<?php
declare(strict_types=1);

namespace App\Shared\Bus;

use App\Shared\Event\DomainEventInterface;

interface EventBusInterface
{
    public function publish(DomainEventInterface ...$domainEvents): void;
}