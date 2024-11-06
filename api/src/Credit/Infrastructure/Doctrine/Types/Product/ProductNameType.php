<?php
declare(strict_types=1);

namespace App\Credit\Infrastructure\Doctrine\Types\Product;

use App\Credit\Domain\Entity\Product\ProductName;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Override;

class ProductNameType extends StringType
{
    const NAME = 'product_name';

    #[Override]
    public function getName(): string
    {
        return self::NAME;
    }

    #[Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): ?ProductName
    {
        return $value ? new ProductName($value) : null;
    }

    /**
     * @param mixed $value
     */
    #[Override]
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof ProductName ? $value->value : $value;
    }
}
