<?php
declare(strict_types=1);

namespace App\Credit\Domain\Service\ApplyCreditCondition;

use App\Credit\Domain\Entity\Client;
use App\Credit\Domain\Entity\Product;
use App\Credit\Domain\Entity\Product\InterestRate;
use App\Credit\Domain\Enum\InterestRateKey;
use App\Credit\Domain\Enum\InterestRateType;
use App\Shared\Enum\State;

final readonly class StateCondition implements ApplyConditionInterface
{
    private InterestRate $interestRate;
    public function __construct()
    {
        $this->interestRate = new InterestRate(InterestRateKey::California, InterestRateType::Add, 11.49);
    }

    public function apply(Product $product, Client $client): void
    {
        if ($client->getAddress()->state === State::CA) {
            if (!$product->hasInterestRate($this->interestRate)) {
                $product->addInterestRate($this->interestRate);
                return;
            }
            $product->removeInterestRate($this->interestRate);
            $product->addInterestRate($this->interestRate);
            return;
        }
        if ($product->hasInterestRate($this->interestRate)) {
            $product->removeInterestRate($this->interestRate);
        }
    }
}
