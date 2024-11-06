<?php

namespace App\Credit\Domain\Event\Product;

use App\Credit\Domain\Entity\Product\InterestRate;
use App\Credit\Domain\Entity\Product\ProductId;
use App\Shared\Infrastructure\Event\DefaultEvent;

final class ProductAddedInterestRateEvent extends DefaultEvent
{
    public function __construct(
        public readonly ProductId $productId,
        public readonly InterestRate $interestRate,
    ) {}
}
