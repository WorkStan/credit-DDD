<?php
declare(strict_types=1);

namespace App\Credit\Infrastructure\Doctrine\Types\Product;

use App\Credit\Domain\Entity\Product\ProductId;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\StringType;
use Override;

class ProductIdType extends StringType
{
    const NAME = 'product_id';

    #[Override]
    public function getName(): string
    {
        return self::NAME;
    }

    #[Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): ?ProductId
    {
        return $value ? new ProductId($value) : null;
    }

    /**
     * @param mixed $value
     */
    #[Override]
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        return $value instanceof ProductId ? $value->value : $value;
    }
}
