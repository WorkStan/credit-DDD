<?php
declare(strict_types=1);

namespace App\Credit\Domain\Service\ValidateCreditCondition;

use App\Credit\Domain\Entity\Client;
use App\Credit\Domain\Entity\Product;
use App\Shared\Enum\Currency;
use App\Shared\Enum\State;

final class AvailableStateCondition implements ValidateConditionInterface
{
    /** @var State[]  */
    private array $availableStates;

    /** @param State[] $availableStates */
    public function __construct(
        array $availableStates
    ) {
        foreach ($availableStates as $availableState) {
            $this->addAvailableState($availableState);
        }
    }

    private function addAvailableState(State $state): void
    {
        $this->availableStates[] = $state;
    }

    public function isValid(Product $product, Client $client): bool
    {
        return in_array($client->getAddress()->state, $this->availableStates);
    }
}
