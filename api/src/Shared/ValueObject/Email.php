<?php
declare(strict_types=1);

namespace App\Shared\ValueObject;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class Email
{
    #[Assert\Email]
    public string $value;

    public function __construct(
        string $value
    ) {
        $this->value = mb_strtolower($value);
    }

    public function isEqual(self $other): bool
    {
        return $this->value === $other->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
