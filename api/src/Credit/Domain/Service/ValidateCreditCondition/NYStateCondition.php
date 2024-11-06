<?php
declare(strict_types=1);

namespace App\Credit\Domain\Service\ValidateCreditCondition;

use App\Credit\Domain\Entity\Client;
use App\Credit\Domain\Entity\Product;
use App\Shared\Enum\State;

final readonly class NYStateCondition implements ValidateConditionInterface
{
    public function isValid(Product $product, Client $client): bool
    {
        return $client->getAddress()->state === State::NY ? (rand(0,1) === 1) : true;
    }
}
