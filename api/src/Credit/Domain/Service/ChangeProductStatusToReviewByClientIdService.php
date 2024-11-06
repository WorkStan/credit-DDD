<?php

namespace App\Credit\Domain\Service;

use App\Credit\Domain\Entity\Client\ClientId;
use App\Credit\Domain\Enum\ProductStatus;
use App\Credit\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Bus\EventBusInterface;

final readonly class ChangeProductStatusToReviewByClientIdService
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private EventBusInterface $eventBus,
    ) {}

    public function execute(ClientId $clientId): void
    {
        $clientProducts = $this->productRepository->findByClientIdStatuses($clientId, ProductStatus::getAsArray());
        foreach ($clientProducts as $clientProduct) {
            if ($clientProduct->canChangeStatus(ProductStatus::Review)) {
                $clientProduct->changeStatus(ProductStatus::Review);
                $this->productRepository->save($clientProduct);
                $clientProduct->isDomainEventsEmpty() ?: $this->eventBus->publish(...$clientProduct->pullDomainEvents());
            }
        }
    }
}
