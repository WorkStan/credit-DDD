<?php
declare(strict_types=1);

namespace App\Shared\ValueObject;

use Symfony\Component\Validator\Constraints as Assert;

abstract readonly class Uuid
{
    #[Assert\Uuid]
    public string $value;

    public function __construct(
        string $value
    ) {
        $this->value = mb_strtolower($value);
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
