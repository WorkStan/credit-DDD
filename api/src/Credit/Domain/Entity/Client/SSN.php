<?php
declare(strict_types=1);

namespace App\Credit\Domain\Entity\Client;

use Symfony\Component\Validator\Constraints as Assert;
final readonly class SSN
{
    public function __construct(
        #[Assert\Regex('/^[0-9\-]+$/')]
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
