<?php
declare(strict_types=1);

namespace App\Shared\ValueObject;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class PhoneNumber
{
    public function __construct(
        #[Assert\Regex('/^\+?[0-9]+$/')]
        public string $countryCode,
        #[Assert\Regex('/^[0-9\-]+$/')]
        public string $number,
    ) {}

    public function isEqual(self $other): bool
    {
        return $this->countryCode === $other->countryCode
            && $this->number === $other->number;
    }

    public function __toString(): string
    {
        return $this->countryCode . $this->number;
    }
}
