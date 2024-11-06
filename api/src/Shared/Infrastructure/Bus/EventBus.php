<?php

namespace App\Shared\Infrastructure\Bus;

use App\Shared\Bus\EventBusInterface;
use App\Shared\Event\DomainEventInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

final readonly class EventBus implements EventBusInterface
{
    public function __construct(private EventDispatcherInterface $eventDispatcher) {}

    public function publish(DomainEventInterface ...$domainEvents): void
    {
        foreach ($domainEvents as $currentEvent) {
            $this->eventDispatcher->dispatch($currentEvent);
        }
    }
}
