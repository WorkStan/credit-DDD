<?php
declare(strict_types=1);

namespace App\Credit\Application\UseCase\GetProduct;

use App\Credit\Domain\Entity\Product;
use App\Credit\Domain\Exception\ProductDoesNotExistException;
use App\Credit\Domain\Repository\ProductRepositoryInterface;

final readonly class Finder
{
    public function __construct(
        private ProductRepositoryInterface $repository
    ) {}

    public function find(Dto $dto): Product
    {
        $product = $this->repository->findById($dto->id);
        if (!$product) {
            throw new ProductDoesNotExistException();
        }
        return $product;
    }
}
