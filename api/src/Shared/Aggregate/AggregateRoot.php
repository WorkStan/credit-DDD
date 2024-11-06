<?php
declare(strict_types=1);

namespace App\Shared\Aggregate;

use App\Shared\Event\DomainEventInterface;

abstract class AggregateRoot
{
    /**
     * @var DomainEventInterface[] $domainEvents
     */
    protected array $domainEvents;

    public function recordDomainEvent(DomainEventInterface $event): self
    {
        $this->domainEvents[] = $event;

        return $this;
    }

    /**
     * @return  DomainEventInterface[]
     */
    public function pullDomainEvents(): array
    {
        $domainEvents = $this->domainEvents;
        $this->domainEvents = [];

        return $domainEvents;
    }

    final public function isDomainEventsEmpty(): bool
    {
        return empty($this->domainEvents);
    }
}
