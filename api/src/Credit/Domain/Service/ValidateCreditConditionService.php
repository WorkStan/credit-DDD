<?php
declare(strict_types=1);

namespace App\Credit\Domain\Service;

use App\Credit\Domain\Entity\Product;
use App\Credit\Domain\Enum\ProductStatus;
use App\Credit\Domain\Exception\ClientDoesNotExistException;
use App\Credit\Domain\Repository\ClientRepositoryInterface;
use App\Credit\Domain\Service\ValidateCreditCondition\ValidateConditionInterface;

final class ValidateCreditConditionService
{
    /** @var ValidateConditionInterface[] $conditions */
    private array $conditions;

    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        ValidateConditionInterface ...$conditions
    ) {
        foreach ($conditions as $condition) {
            $this->addCondition($condition);
        }
    }

    private function addCondition(ValidateConditionInterface $condition): void
    {
        $this->conditions[] = $condition;
    }
    public function validate(Product $product): void
    {
        $client = $this->clientRepository->findById($product->getClientId());
        if (!$client) {
            throw new ClientDoesNotExistException('Client not found');
        }
        foreach ($this->conditions as $condition) {
            if (!$condition->isValid($product, $client)) {
                $product->canChangeStatus(ProductStatus::NotAvailable) ? $product->changeStatus(ProductStatus::NotAvailable) : null;
            }
        }
        $product->canChangeStatus(ProductStatus::Available) ? $product->changeStatus(ProductStatus::Available) : null;
    }
}
