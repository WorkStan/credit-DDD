<?php

namespace App\Credit\Application\Subscribers;

use App\Credit\Domain\Event\Client\ClientUpdatedAddressEvent;
use App\Credit\Domain\Event\Client\ClientUpdatedAgeEvent;
use App\Credit\Domain\Event\Client\ClientUpdatedFicoEvent;
use App\Credit\Domain\Event\Client\ClientUpdatedIncomeEvent;
use App\Credit\Domain\Service\ChangeProductStatusToReviewByClientIdService;
use App\Shared\Infrastructure\EventSubscriber\DefaultEventSubscriber;

final class ClientSubscriber extends DefaultEventSubscriber
{
    public function __construct(
        private ChangeProductStatusToReviewByClientIdService $changeStatusService,
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            ClientUpdatedAddressEvent::class => 'onClientUpdatedAddress',
            ClientUpdatedFicoEvent::class => 'onClientUpdatedFico',
            ClientUpdatedAgeEvent::class => 'onClientUpdatedAge',
            ClientUpdatedIncomeEvent::class => 'onClientUpdatedIncome',
        ];
    }

    public function onClientUpdatedAddress(ClientUpdatedAddressEvent $event): void
    {
        $this->changeStatusService->execute($event->clientId);
    }
    public function onClientUpdatedFico(ClientUpdatedFicoEvent $event): void
    {
        $this->changeStatusService->execute($event->clientId);
    }
    public function onClientUpdatedAge(ClientUpdatedAgeEvent $event): void
    {
        $this->changeStatusService->execute($event->clientId);
    }
    public function onClientUpdatedIncome(ClientUpdatedIncomeEvent $event): void
    {
        $this->changeStatusService->execute($event->clientId);
    }
}
