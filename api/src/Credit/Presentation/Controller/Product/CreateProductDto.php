<?php
declare(strict_types=1);

namespace App\Credit\Presentation\Controller\Product;

use App\Shared\Enum\Currency;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateProductDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Regex('/^[0-9a-fA-F]{8}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{4}\b-[0-9a-fA-F]{12}$/')]
        public string $clientId,
        #[Assert\NotBlank]
        #[Assert\Regex('/^[a-zA-Z\s]+$/')]
        public string $name,
        #[Assert\NotBlank]
        #[Assert\Range(
            min: 0,
            max: 120,
        )]
        public int $loanTerm,
        #[Assert\NotBlank]
        #[Assert\GreaterThan(
            value: 0,
        )]
        public float $defaultInterestRate,
        #[Assert\NotBlank]
        #[Assert\GreaterThan(
            value: 0,
        )]
        public int $moneyAmount,
        #[Assert\NotBlank]
        #[Assert\Choice(callback: [Currency::class, 'getAsArray'])]
        public string $moneyCurrency,
    ) {}
}
