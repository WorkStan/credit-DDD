<?php
declare(strict_types=1);

namespace App\Credit\Infrastructure\Doctrine\Types\Client;

use App\Credit\Domain\Entity\Client\FICO;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;
use Override;

class ClientFicoType extends IntegerType
{
    const NAME = 'client_fico';

    #[Override]
    public function getName(): string
    {
        return self::NAME;
    }

    #[Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): ?FICO
    {
        return $value ? new FICO($value) : null;
    }

    /**
     * @param mixed $value
     */
    #[Override]
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        return $value instanceof FICO ? $value->value : $value;
    }
}
