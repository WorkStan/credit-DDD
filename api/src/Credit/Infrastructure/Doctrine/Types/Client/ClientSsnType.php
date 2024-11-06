<?php
declare(strict_types=1);

namespace App\Credit\Infrastructure\Doctrine\Types\Client;

use App\Credit\Domain\Entity\Client\SSN;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Override;

class ClientSsnType extends StringType
{
    const NAME = 'client_ssn';

    #[Override]
    public function getName(): string
    {
        return self::NAME;
    }

    #[Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): ?SSN
    {
        return $value ? new SSN($value) : null;
    }

    /**
     * @param mixed $value
     */
    #[Override]
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof SSN ? $value->value : $value;
    }
}
