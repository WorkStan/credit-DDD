<?php
declare(strict_types=1);

namespace App\Credit\Domain\Entity;

use App\Credit\Domain\Entity\Client\Address;
use App\Credit\Domain\Entity\Client\Age;
use App\Credit\Domain\Entity\Client\ClientId;
use App\Credit\Domain\Entity\Client\ClientName;
use App\Credit\Domain\Entity\Client\FICO;
use App\Credit\Domain\Entity\Client\SSN;
use App\Credit\Domain\Entity\Dto\CreateClientDto;
use App\Credit\Domain\Event\Client\ClientCreatedEvent;
use App\Credit\Domain\Event\Client\ClientUpdatedAddressEvent;
use App\Credit\Domain\Event\Client\ClientUpdatedAgeEvent;
use App\Credit\Domain\Event\Client\ClientUpdatedEmailEvent;
use App\Credit\Domain\Event\Client\ClientUpdatedFicoEvent;
use App\Credit\Domain\Event\Client\ClientUpdatedIncomeEvent;
use App\Credit\Domain\Event\Client\ClientUpdatedNameEvent;
use App\Credit\Domain\Event\Client\ClientUpdatedPhoneNumberEvent;
use App\Credit\Domain\Event\Client\ClientUpdatedSsnEvent;
use App\Credit\Infrastructure\Doctrine\Types\Client\ClientAgeType;
use App\Credit\Infrastructure\Doctrine\Types\Client\ClientFicoType;
use App\Credit\Infrastructure\Doctrine\Types\Client\ClientIdType;
use App\Credit\Infrastructure\Doctrine\Types\Client\ClientSsnType;
use App\Credit\Infrastructure\Repository\ClientRepository;
use App\Shared\Aggregate\AggregateRoot;
use App\Shared\Entity\Embeddable\Money;
use App\Shared\Infrastructure\Doctrine\Types\EmailType;
use App\Shared\Infrastructure\Doctrine\Types\PhoneNumberType;
use App\Shared\ValueObject\Email;
use App\Shared\ValueObject\PhoneNumber;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
final class Client extends AggregateRoot
{
    private function __construct(
        #[ORM\Id]
        #[ORM\Column(type: ClientIdType::NAME)]
        private readonly ClientId $id,
        #[ORM\Embedded(class: ClientName::class)]
        private ClientName        $name,
        #[ORM\Column(type: ClientAgeType::NAME)]
        private Age               $age,
        #[ORM\Embedded(class: Address::class)]
        private Address           $address,
        #[ORM\Column(type: ClientSsnType::NAME)]
        private SSN               $ssn,
        #[ORM\Column(type: ClientFicoType::NAME)]
        private FICO              $fico,
        #[ORM\Column(type: EmailType::NAME)]
        private Email             $email,
        #[ORM\Column(type: PhoneNumberType::NAME)]
        private PhoneNumber $phoneNumber,
        #[ORM\Embedded(class: Money::class)]
        private Money              $income = new Money(0),
    ) {}

    public static function create(CreateClientDto $dto): self
    {
        $client = new self($dto->id, $dto->name, $dto->age, $dto->address, $dto->ssn, $dto->fico, $dto->email, $dto->phoneNumber, $dto->income);
        $client->recordDomainEvent(new ClientCreatedEvent($dto->id));
        return $client;
    }

    public function getId(): ClientId
    {
        return $this->id;
    }

    public function getName(): ClientName
    {
        return $this->name;
    }

    public function changeName(ClientName $name): void
    {
        $oldName = $this->name;
        $this->name = $newName = $name;
        $this->recordDomainEvent(new ClientUpdatedNameEvent($this->id, $oldName, $newName));
    }

    public function getAge(): Age
    {
        return $this->age;
    }

    public function changeAge(Age $age): void
    {
        $oldAge = $this->age;
        $this->age = $newAge = $age;
        $this->recordDomainEvent(new ClientUpdatedAgeEvent($this->id, $oldAge, $newAge));
    }

    public function getAddress(): Address
    {
        return $this->address;
    }

    public function changeAddress(Address $address): void
    {
        $oldAddress = $this->address;
        $this->address = $newAddress = $address;
        $this->recordDomainEvent(new ClientUpdatedAddressEvent($this->id, $oldAddress, $newAddress));
    }

    public function getSSN(): SSN
    {
        return $this->ssn;
    }

    public function changeSsn(SSN $ssn): void
    {
        $oldSSN = $this->ssn;
        $this->ssn = $newSSN = $ssn;
        $this->recordDomainEvent(new ClientUpdatedSSNEvent($this->id, $oldSSN, $newSSN));
    }

    public function getFico(): FICO
    {
        return $this->fico;
    }

    public function changeFico(FICO $fico): void
    {
        $oldFico = $this->fico;
        $this->fico = $newFico = $fico;
        $this->recordDomainEvent(new ClientUpdatedFicoEvent($this->id, $oldFico, $newFico));
    }

    public function getEmail(): Email
    {
        return $this->email;
    }

    public function changeEmail(Email $email): void
    {
        $oldEmail = $this->email;
        $this->email = $newEmail = $email;
        $this->recordDomainEvent(new ClientUpdatedEmailEvent($this->id, $oldEmail, $newEmail));
    }

    public function getPhoneNumber(): PhoneNumber
    {
        return $this->phoneNumber;
    }

    public function changePhoneNumber(PhoneNumber $phoneNumber): void
    {
        $oldPhoneNumber = $this->phoneNumber;
        $this->phoneNumber = $newPhoneNumber = $phoneNumber;
        $this->recordDomainEvent(new ClientUpdatedPhoneNumberEvent($this->id, $oldPhoneNumber, $newPhoneNumber));
    }

    public function getIncome(): Money
    {
        return $this->income;
    }

    public function changeIncome(Money $money): void
    {
        $oldIncome = $this->income;
        $this->income = $newIncome = $money;
        $this->recordDomainEvent(new ClientUpdatedIncomeEvent($this->id, $oldIncome, $newIncome));
    }
}
