<?php
declare(strict_types=1);

namespace App\Credit\Domain\Entity\Dto;

use App\Credit\Domain\Entity\Client\Address;
use App\Credit\Domain\Entity\Client\Age;
use App\Credit\Domain\Entity\Client\ClientId;
use App\Credit\Domain\Entity\Client\ClientName;
use App\Credit\Domain\Entity\Client\FICO;
use App\Credit\Domain\Entity\Client\SSN;
use App\Shared\Entity\Embeddable\Money;
use App\Shared\ValueObject\Email;
use App\Shared\ValueObject\PhoneNumber;

readonly class CreateClientDto
{
    public function __construct(
        public ClientId    $id,
        public ClientName  $name,
        public Age         $age,
        public Address     $address,
        public SSN         $ssn,
        public FICO        $fico,
        public Email       $email,
        public PhoneNumber $phoneNumber,
        public Money       $income
    ) {}
}
