<?php
declare(strict_types=1);

namespace App\Credit\Infrastructure\Repository;

use App\Credit\Domain\Entity\Client;
use App\Credit\Domain\Entity\Client\ClientId;
use App\Credit\Domain\Repository\ClientRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Client>
 */
final class ClientRepository extends ServiceEntityRepository implements ClientRepositoryInterface
{
    public function __construct(private ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function findById(ClientId $id): ?Client
    {
        return $this->find($id->value);
    }

    public function save(Client $client): void
    {
        $em = $this->registry->getManager();
        $em->persist($client);
        $em->flush();
    }
}
