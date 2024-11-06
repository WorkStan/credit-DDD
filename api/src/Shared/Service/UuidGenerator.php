<?php
declare(strict_types=1);

namespace App\Shared\Service;

use Symfony\Component\Uid\Uuid;

final readonly class UuidGenerator implements UuidGeneratorInterface
{
    public function generate(): string
    {
        return Uuid::v4()->toString();
    }
}
