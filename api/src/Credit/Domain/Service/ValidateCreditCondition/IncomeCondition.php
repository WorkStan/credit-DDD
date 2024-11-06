<?php
declare(strict_types=1);

namespace App\Credit\Domain\Service\ValidateCreditCondition;

use App\Credit\Domain\Entity\Client;
use App\Credit\Domain\Entity\Product;
use App\Shared\Enum\Currency;

final readonly class IncomeCondition implements ValidateConditionInterface
{
    public function __construct(
        private int $minValue
    ) {}

    public function isValid(Product $product, Client $client): bool
    {
        return ($client->getIncome()->getValue() >= $this->minValue && $client->getIncome()->isCurrencyEqualByCurrency(Currency::USD));
    }
}
