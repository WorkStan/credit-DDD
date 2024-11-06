<?php

namespace App\Credit\Domain\Event\Product;

use App\Credit\Domain\Entity\Product\ProductId;
use App\Credit\Domain\Enum\ProductStatus;
use App\Shared\Infrastructure\Event\DefaultEvent;

final class ProductStatusChangedEvent extends DefaultEvent
{
    public function __construct(
        public readonly ProductId $productId,
        public readonly ProductStatus $oldStatus,
        public readonly ProductStatus $newStatus,
    ) {}
}
