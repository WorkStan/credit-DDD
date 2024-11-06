<?php
declare(strict_types=1);

namespace App\Credit\Domain\Service\ApplyCreditCondition;

use App\Credit\Domain\Entity\Client;
use App\Credit\Domain\Entity\Product;

interface ApplyConditionInterface
{
    public function apply(Product $product, Client $client): void;
}
