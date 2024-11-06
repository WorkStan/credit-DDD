<?php
declare(strict_types=1);

namespace App\Credit\Domain\Entity\Client;

use Doctrine\DBAL\Types\Types;
use Symfony\Component\Validator\Constraints as Assert;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Embeddable]
final readonly class ClientName
{
    public function __construct(
        #[Assert\Regex('/^[a-zA-Z]+$/')]
        #[ORM\Column(type: Types::STRING, length: 255)]
        public string $firstName,
        #[Assert\Regex('/^[a-zA-Z]+$/')]
        #[ORM\Column(type: Types::STRING, length: 255)]
        public string $lastName
    ) {}

    public function isEqual(self $other): bool
    {
        return $this->firstName === $other->firstName && $this->lastName === $other->lastName;
    }

    public function __toString(): string
    {
        return $this->firstName . ' ' . $this->lastName;
    }
}
