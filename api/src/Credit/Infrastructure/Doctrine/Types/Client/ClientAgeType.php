<?php
declare(strict_types=1);

namespace App\Credit\Infrastructure\Doctrine\Types\Client;

use App\Credit\Domain\Entity\Client\Age;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;
use InvalidArgumentException;
use Override;

class ClientAgeType extends IntegerType
{
    const NAME = 'client_age';

    #[Override]
    public function getName(): string
    {
        return self::NAME;
    }

    #[Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): ?Age
    {
        return !empty($value) ? new Age($value) : null;
    }

    /**
     * @param mixed $value
     */
    #[Override]
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        return $value instanceof Age ? $value->value : $value;
    }
}
