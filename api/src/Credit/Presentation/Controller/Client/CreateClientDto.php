<?php
declare(strict_types=1);

namespace App\Credit\Presentation\Controller\Client;

use App\Shared\Enum\State;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class CreateClientDto
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Regex('/^[a-zA-Z]+$/')]
        public string $firstName,
        #[Assert\NotBlank]
        #[Assert\Regex('/^[a-zA-Z]+$/')]
        public string $lastName,
        #[Assert\NotBlank]
        #[Assert\Range(
            min: 0,
            max: 199,
        )]
        public int $age,
        #[Assert\NotBlank]
        #[Assert\Regex('/^[a-zA-Z\s]+$/')]
        public string $city,
        #[Assert\NotBlank]
        #[Assert\Choice(callback: [State::class, 'getAsArray'])]
        public string $state,
        #[Assert\NotBlank]
        #[Assert\Regex('/^\d{5}(?:[-\s]\d{4})?$/')]
        public string $zip,
        #[Assert\NotBlank]
        #[Assert\Regex('/^[0-9\-]+$/')]
        public string $ssn,
        #[Assert\NotBlank]
        #[Assert\Range(
            min: 300,
            max: 850,
        )]
        public int $fico,
        #[Assert\NotBlank]
        #[Assert\Email]
        public string $email,
        #[Assert\NotBlank]
        #[Assert\Regex('/^\+?[0-9]+$/')]
        public string $phoneCode,
        #[Assert\NotBlank]
        #[Assert\Regex('/^[0-9\-]+$/')]
        public string $phoneNumber,
        #[Assert\GreaterThanOrEqual(
            value: 0,
        )]
        public int $incomeUsdPerMonth,
    ) {}
}
