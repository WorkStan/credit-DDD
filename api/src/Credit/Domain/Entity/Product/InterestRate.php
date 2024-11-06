<?php
declare(strict_types=1);

namespace App\Credit\Domain\Entity\Product;

use App\Credit\Domain\Enum\InterestRateKey;
use App\Credit\Domain\Enum\InterestRateType;
use Symfony\Component\Validator\Constraints as Assert;
final readonly class InterestRate
{
    public function __construct(
        public InterestRateKey $key,
        public InterestRateType $type,
        #[Assert\GreaterThan(
            value: 0,
        )]
        public float $value,
    ) {}

    public function __toString(): string
    {
        return (string)$this->value;
    }
}