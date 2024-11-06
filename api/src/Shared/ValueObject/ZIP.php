<?php
declare(strict_types=1);

namespace App\Shared\ValueObject;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class ZIP
{
    public function __construct(
        #[Assert\Regex('/^\d{5}(?:[-\s]\d{4})?$/')]
        public string $value,
    ) {}

    public function isEqual(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
