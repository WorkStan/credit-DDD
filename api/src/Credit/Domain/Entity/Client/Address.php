<?php
declare(strict_types=1);

namespace App\Credit\Domain\Entity\Client;

use App\Shared\Enum\State;
use App\Shared\Infrastructure\Doctrine\Types\ZipType;
use App\Shared\ValueObject\ZIP;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Embeddable]
final readonly class Address
{
    public function __construct(
        #[Assert\Regex('/^[a-zA-Z\s]+$/')]
        #[ORM\Column(type: Types::STRING, length: 255)]
        public string $city,
        #[ORM\Column(type: Types::STRING, enumType: State::class)]
        public State  $state,
        #[ORM\Column(type: ZipType::NAME)]
        public ZIP    $zip,
    ) {}

    public function isEqual(self $other): bool
    {
        return $this->city === $other->city
            && $this->state === $other->state
            && $this->zip->isEqual($other->zip);
    }
    public function __toString(): string
    {
        return $this->city . ', ' . $this->state->value . ', ' . $this->zip;
    }
}
