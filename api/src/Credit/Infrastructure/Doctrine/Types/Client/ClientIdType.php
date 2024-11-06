<?php
declare(strict_types=1);

namespace App\Credit\Infrastructure\Doctrine\Types\Client;

use App\Credit\Domain\Entity\Client\ClientId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Override;

class ClientIdType extends StringType
{
    const NAME = 'client_id';

    #[Override]
    public function getName(): string
    {
        return self::NAME;
    }

    #[Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): ?ClientId
    {
        return $value ? new ClientId($value) : null;
    }

    /**
     * @param mixed $value
     */
    #[Override]
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof ClientId ? $value->value : $value;
    }
}
