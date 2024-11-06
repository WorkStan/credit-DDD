<?php

namespace App\Credit\Application\UseCase\CreateClient;

use App\Credit\Domain\Entity\Client;
use App\Credit\Domain\Repository\ClientRepositoryInterface;
use App\Shared\Bus\EventBusInterface;

class Handler
{
    public function __construct(
        private EventBusInterface $eventBus,
        private ClientRepositoryInterface $clientRepository
    ) {}

    public function handle(Dto $command): void
    {
        $client = Client::create($command);
        $this->clientRepository->save($client);
        $client->isDomainEventsEmpty() ?: $this->eventBus->publish(...$client->pullDomainEvents());
    }
}
