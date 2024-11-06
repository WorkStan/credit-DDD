<?php
declare(strict_types=1);

namespace App\Credit\Domain\Service\ValidateCreditCondition;

use App\Credit\Domain\Entity\Client;
use App\Credit\Domain\Entity\Product;

final readonly class AgeCondition implements ValidateConditionInterface
{
    public function __construct(
        private int $minValue,
        private int $maxValue
    ) {}

    public function isValid(Product $product, Client $client): bool
    {
        return ($client->getAge()->value >= $this->minValue && $client->getAge()->value <= $this->maxValue);
    }
}
