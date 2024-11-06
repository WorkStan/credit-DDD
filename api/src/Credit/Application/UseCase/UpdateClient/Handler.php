<?php

namespace App\Credit\Application\UseCase\UpdateClient;

use App\Credit\Domain\Exception\ClientDoesNotExistException;
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
        $client = $this->clientRepository->findById($command->id);
        if (!$client) {
            throw new ClientDoesNotExistException('Client not found');
        }

        $client->getName()->isEqual($command->name) ?: $client->changeName($command->name);
        $client->getAge()->isEqual($command->age) ?: $client->changeAge($command->age);
        $client->getAddress()->isEqual($command->address) ?: $client->changeAddress($command->address);
        $client->getSSN()->isEqual($command->ssn) ?: $client->changeSsn($command->ssn);
        $client->getFico()->isEqual($command->fico) ?: $client->changeFico($command->fico);
        $client->getEmail()->isEqual($command->email) ?: $client->changeEmail($command->email);
        $client->getPhoneNumber()->isEqual($command->phoneNumber) ?: $client->changePhoneNumber($command->phoneNumber);
        $client->getIncome()->isEqual($command->income) ?: $client->changeIncome($command->income);

        $this->clientRepository->save($client);
        $client->isDomainEventsEmpty() ?: $this->eventBus->publish(...$client->pullDomainEvents());
    }
}
