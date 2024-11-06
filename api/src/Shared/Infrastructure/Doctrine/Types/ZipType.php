<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Types;

use App\Shared\ValueObject\ZIP;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Override;

class ZipType extends StringType
{
    const NAME = 'zip';

    #[Override]
    public function getName(): string
    {
        return self::NAME;
    }

    #[Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): ?ZIP
    {
        return $value ? new ZIP($value) : null;
    }

    /**
     * @param mixed $value
     */
    #[Override]
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof ZIP ? $value->value : $value;
    }
}
