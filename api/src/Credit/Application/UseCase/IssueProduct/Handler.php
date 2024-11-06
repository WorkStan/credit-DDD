<?php
declare(strict_types=1);

namespace App\Credit\Application\UseCase\IssueProduct;

use App\Credit\Domain\Enum\ProductStatus;
use App\Credit\Domain\Exception\ProductDoesNotExistException;
use App\Credit\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Bus\EventBusInterface;

final readonly class Handler
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private EventBusInterface $eventBus,
    ) {}

    public function handle(Dto $dto): void
    {
        $product = $this->productRepository->findById($dto->id);
        if (!$product) {
            throw new ProductDoesNotExistException();
        }
        $product->changeStatus(ProductStatus::Issued);
        $this->productRepository->save($product);
        $product->isDomainEventsEmpty() ?: $this->eventBus->publish(...$product->pullDomainEvents());
    }
}
