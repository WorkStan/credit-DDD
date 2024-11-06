<?php
declare(strict_types=1);

namespace App\Credit\Domain\Entity;

use App\Credit\Domain\Entity\Client\ClientId;
use App\Credit\Domain\Entity\Dto\CreateProductDto;
use App\Credit\Domain\Entity\Product\InterestRate;
use App\Credit\Domain\Entity\Product\InterestRateCollection;
use App\Credit\Domain\Entity\Product\LoanTerm;
use App\Credit\Domain\Entity\Product\ProductId;
use App\Credit\Domain\Entity\Product\ProductName;
use App\Credit\Domain\Enum\ProductStatus;
use App\Credit\Domain\Event\Product\ProductAddedInterestRateEvent;
use App\Credit\Domain\Event\Product\ProductCreatedEvent;
use App\Credit\Domain\Event\Product\ProductRemovedInterestRateEvent;
use App\Credit\Domain\Event\Product\ProductStatusChangedEvent;
use App\Credit\Domain\Exception\InterestRateAlreadyExistException;
use App\Credit\Domain\Exception\InterestRateDoesNotExistException;
use App\Credit\Domain\Exception\InterestRateNegativeException;
use App\Credit\Domain\Exception\StatusCantBeChangedException;
use App\Credit\Infrastructure\Doctrine\Types\Client\ClientIdType;
use App\Credit\Infrastructure\Doctrine\Types\Product\InterestRateCollectionType;
use App\Credit\Infrastructure\Doctrine\Types\Product\LoanTermType;
use App\Credit\Infrastructure\Doctrine\Types\Product\ProductIdType;
use App\Credit\Infrastructure\Doctrine\Types\Product\ProductNameType;
use App\Credit\Infrastructure\Repository\ProductRepository;
use App\Shared\Aggregate\AggregateRoot;
use App\Shared\Entity\Embeddable\Money;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
final class Product extends AggregateRoot
{
    /** @var array<string, string[]> */
    private array $availableStatusChanges = [
        ProductStatus::New->value => [ProductStatus::Available->value, ProductStatus::NotAvailable->value, ProductStatus::Review->value],
        ProductStatus::Review->value => [ProductStatus::Available->value, ProductStatus::NotAvailable->value],
        ProductStatus::Available->value => [ProductStatus::Issued->value, ProductStatus::NotAvailable->value, ProductStatus::Review->value],
        ProductStatus::NotAvailable->value => [ProductStatus::Review->value],
        ProductStatus::Issued->value => [ProductStatus::Repaid->value],
    ];

    private function __construct(
        #[ORM\Id]
        #[ORM\Column(type: ProductIdType::NAME)]
        private readonly ProductId      $id,
        #[ORM\Column(type: ClientIdType::NAME)]
        private readonly ClientId       $clientId,
        #[ORM\Column(type: ProductNameType::NAME)]
        private ProductName             $name,
        #[ORM\Column(type: LoanTermType::NAME)]
        private LoanTerm                $loanTerm,
        #[ORM\Column(type: InterestRateCollectionType::NAME)]
        private InterestRateCollection  $interestRates,
        #[ORM\Embedded(class: Money::class)]
        private Money                   $money,
        #[ORM\Column(type: Types::STRING, enumType: ProductStatus::class)]
        private ProductStatus           $status = ProductStatus::New
    ) {}

    public static function create(
        CreateProductDto $dto
    ): Product
    {
        $product = new self($dto->id, $dto->clientId, $dto->name, $dto->loanTerm, $dto->interestRates, $dto->money);
        $product->recordDomainEvent(new ProductCreatedEvent($dto->id));
        return $product;
    }

    public function getId(): ProductId
    {
        return $this->id;
    }

    public function getName(): ProductName
    {
        return $this->name;
    }

    public function getLoanTerm(): LoanTerm
    {
        return $this->loanTerm;
    }

    public function getInterestRates(): InterestRateCollection
    {
        return $this->interestRates;
    }

    public function getMoney(): Money
    {
        return $this->money;
    }

    public function getClientId(): ClientId
    {
        return $this->clientId;
    }

    public function getStatus(): ProductStatus
    {
        return $this->status;
    }

    public function canChangeStatus(ProductStatus $status): bool
    {
        return array_key_exists($this->status->value, $this->availableStatusChanges)
            && in_array($status->value, $this->availableStatusChanges[$this->status->value]);
    }
    /**
     * @throws StatusCantBeChangedException
     */
    public function changeStatus(ProductStatus $status): void
    {
        if (!$this->canChangeStatus($status)) {
            throw new StatusCantBeChangedException('Status can\'t changed');
        }
        $oldStatus = $this->status;
        $this->status = $newStatus = $status;
        $this->recordDomainEvent(new ProductStatusChangedEvent($this->id, $oldStatus, $newStatus));
    }

    /**
     * @throws InterestRateAlreadyExistException
     * @throws InterestRateNegativeException
     */
    public function addInterestRate(InterestRate $interestRate): void
    {
        $newInterestRates = $this->interestRates->addInterestRate($interestRate);
        if ($newInterestRates->getTotalInterestRate() < 0) {
            throw new InterestRateNegativeException('Total interest rate must be greater than 0');
        }
        $this->interestRates = $newInterestRates;
        $this->recordDomainEvent(new ProductAddedInterestRateEvent($this->id, $interestRate));
    }

    public function hasInterestRate(InterestRate $interestRate): bool
    {
        return $this->interestRates->hasInterestRate($interestRate);
    }

    /**
     * @throws InterestRateDoesNotExistException
     */
    public function removeInterestRate(InterestRate $interestRate): void
    {
        $newInterestRates = $this->interestRates->removeInterestRate($interestRate);
        $this->interestRates = $newInterestRates;
        $this->recordDomainEvent(new ProductRemovedInterestRateEvent($this->id, $interestRate));
    }

    public function getTotalInterestRate(): float
    {
        return $this->interestRates->getTotalInterestRate();
    }
}
