<?php

namespace App\Credit\Application\UseCase\ApplyAndValidateProduct;

use App\Credit\Domain\Entity\Product;
use App\Credit\Domain\Exception\ClientDoesNotExistException;
use App\Credit\Domain\Exception\ProductDoesNotExistException;
use App\Credit\Domain\Repository\ClientRepositoryInterface;
use App\Credit\Domain\Repository\ProductRepositoryInterface;
use App\Credit\Domain\Service\ApplyCreditConditionService;
use App\Credit\Domain\Service\ValidateCreditConditionService;
use App\Shared\Bus\EventBusInterface;

class Handler
{
    public function __construct(
        private EventBusInterface $eventBus,
        private ProductRepositoryInterface $productRepository,
        private ApplyCreditConditionService  $applyCreditConditionService,
        private ValidateCreditConditionService $validateCreditConditionService,
    ) {}

    public function handle(Dto $command): void
    {
        $product = $this->productRepository->findById($command->productId);
        if (!$product) {
            throw new ProductDoesNotExistException('Product not found');
        }
        $this->applyCreditConditionService->apply($product);
        $this->validateCreditConditionService->validate($product);
        $this->productRepository->save($product);
        $product->isDomainEventsEmpty() ?: $this->eventBus->publish(...$product->pullDomainEvents());
    }
}
