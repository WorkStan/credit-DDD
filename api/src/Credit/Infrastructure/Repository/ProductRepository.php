<?php
declare(strict_types=1);

namespace App\Credit\Infrastructure\Repository;

use App\Credit\Domain\Entity\Client\ClientId;
use App\Credit\Domain\Entity\Product\ProductId;
use App\Credit\Domain\Entity\Product;
use App\Credit\Domain\Repository\ProductRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Product>
 */
final class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(private ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findById(ProductId $id): ?Product
    {
        return $this->find($id->value);
    }

    public function findByClientIdStatuses(ClientId $clientId, array $productStatuses): array
    {
        return $this->findBy(['clientId' => $clientId->value, 'status' => $productStatuses]);
    }

    public function save(Product $product): void
    {
        $em = $this->registry->getManager();
        $em->persist($product);
        $em->flush();
    }
}
