<?php
declare(strict_types=1);

namespace App\Shared\Entity\Embeddable;

use App\Shared\Enum\Currency;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use DomainException;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Embeddable]
final readonly class Money
{
    public function __construct(
        #[Assert\GreaterThanOrEqual(
            value: 0,
        )]
        #[ORM\Column(type: Types::INTEGER)]
        private int $value,
        #[Assert\Range(
            min: -5,
            max: 5,
        )]
        #[ORM\Column(type: Types::INTEGER)]
        private int $pow = 0,
        #[ORM\Column(type: Types::STRING, enumType: Currency::class)]
        public Currency $currency = Currency::USD
    ) {}

    public function isEqual(self $other): bool
    {
        return $this->getValue() === $other->getValue()
            && $this->isCurrencyEqual($other);
    }
    public function __toString(): string
    {
        return $this->getValue() . ' ' . $this->currency->value;
    }

    public function getValue(): float
    {
        return $this->value * pow(10, $this->pow);
    }

    public function isCurrencyEqual(self $other): bool
    {
        return $this->currency === $other->currency;
    }

    public function isCurrencyEqualByCurrency(Currency $currency): bool
    {
        return $this->currency === $currency;
    }

    public function isGreaterThan(self $other): bool
    {
        if ($this->isCurrencyEqual($other)) {
            return $this->getValue() > $other->getValue();
        }
        throw new DomainException('Currency\'s are not equal');
    }
}
