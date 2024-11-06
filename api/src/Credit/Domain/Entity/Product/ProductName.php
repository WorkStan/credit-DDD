<?php
declare(strict_types=1);

namespace App\Credit\Domain\Entity\Product;

use Symfony\Component\Validator\Constraints as Assert;
final readonly class ProductName
{
    public function __construct(
        #[Assert\Regex('/^[a-zA-Z\s]+$/')]
        public string $value,
    ) {}

    public function __toString(): string
    {
        return $this->value;
    }
}
