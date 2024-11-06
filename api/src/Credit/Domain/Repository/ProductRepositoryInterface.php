<?php
declare(strict_types=1);

namespace App\Credit\Domain\Repository;

use App\Credit\Domain\Entity\Client\ClientId;
use App\Credit\Domain\Entity\Product;
use App\Credit\Domain\Entity\Product\ProductId;
use App\Credit\Domain\Enum\ProductStatus;

interface ProductRepositoryInterface
{
    public function findById(ProductId $id): ?Product;

    /**
     * @param string[] $productStatuses
     * @return Product[]
     */
    public function findByClientIdStatuses(ClientId $clientId, array $productStatuses): array;

    public function save(Product $product): void;
}
