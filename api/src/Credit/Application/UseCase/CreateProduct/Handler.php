<?php

namespace App\Credit\Application\UseCase\CreateProduct;

use App\Credit\Domain\Entity\Product;
use App\Credit\Domain\Exception\ClientDoesNotExistException;
use App\Credit\Domain\Repository\ClientRepositoryInterface;
use App\Credit\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Bus\EventBusInterface;

class Handler
{
    public function __construct(
        private EventBusInterface $eventBus,
        private ProductRepositoryInterface $productRepository,
        private ClientRepositoryInterface $clientRepository
    ) {}

    public function handle(Dto $command): void
    {
        $client = $this->clientRepository->findById($command->clientId);
        if (!$client) {
            throw new ClientDoesNotExistException('Client not found');
        }
        $product = Product::create($command);
        $this->productRepository->save($product);
        $product->isDomainEventsEmpty() ?: $this->eventBus->publish(...$product->pullDomainEvents());
    }
}
