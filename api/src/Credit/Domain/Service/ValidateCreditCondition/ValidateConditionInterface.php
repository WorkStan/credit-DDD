<?php
declare(strict_types=1);

namespace App\Credit\Domain\Service\ValidateCreditCondition;

use App\Credit\Domain\Entity\Client;
use App\Credit\Domain\Entity\Product;

interface ValidateConditionInterface
{
    public function isValid(Product $product, Client $client): bool;
}
