<?php
declare(strict_types=1);

namespace App\Credit\Domain\Entity\Product;

use Symfony\Component\Validator\Constraints as Assert;
final readonly class LoanTerm
{
    public function __construct(
        #[Assert\Range(
            min: 0,
            max: 120,
        )]
        public int $value,
    ) {}

    public function __toString(): string
    {
        return (string)$this->value . ' month';
    }
}
