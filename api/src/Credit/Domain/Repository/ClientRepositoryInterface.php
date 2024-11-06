<?php
declare(strict_types=1);

namespace App\Credit\Domain\Repository;

use App\Credit\Domain\Entity\Client;
use App\Credit\Domain\Entity\Client\ClientId;

interface ClientRepositoryInterface
{
    public function findById(ClientId $id): ?Client;
    public function save(Client $client): void;
}
