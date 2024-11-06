<?php
declare(strict_types=1);

namespace App\Credit\Domain\Service;

use App\Credit\Domain\Entity\Product;
use App\Credit\Domain\Exception\ClientDoesNotExistException;
use App\Credit\Domain\Repository\ClientRepositoryInterface;
use App\Credit\Domain\Service\ApplyCreditCondition\ApplyConditionInterface;

final class ApplyCreditConditionService
{
    /** @var ApplyConditionInterface[] $conditions */
    private array $conditions;

    public function __construct(
        private ClientRepositoryInterface $clientRepository,
        ApplyConditionInterface ...$conditions,
    ) {
        foreach ($conditions as $condition) {
            $this->addCondition($condition);
        }
    }

    private function addCondition(ApplyConditionInterface $condition): void
    {
        $this->conditions[] = $condition;
    }

    public function apply(Product $product): void
    {
        $client = $this->clientRepository->findById($product->getClientId());
        if (!$client) {
            throw new ClientDoesNotExistException('Client not found');
        }
        foreach ($this->conditions as $condition) {
            $condition->apply($product, $client);
        }
    }
}
