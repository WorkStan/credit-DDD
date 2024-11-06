<?php
declare(strict_types=1);

namespace App\Credit\Infrastructure\Doctrine\Types\Product;

use App\Credit\Domain\Entity\Product\InterestRateCollection;
use App\Credit\Domain\Entity\Product\LoanTerm;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\ConversionException;
use Doctrine\DBAL\Types\IntegerType;
use Doctrine\DBAL\Types\JsonType;
use InvalidArgumentException;
use JsonException;
use Override;

class InterestRateCollectionType extends JsonType
{
    const NAME = 'interest_rate_collection';

    #[Override]
    public function getName(): string
    {
        return self::NAME;
    }

    #[Override]
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (is_resource($value)) {
            $value = stream_get_contents($value);
        }

        try {
            $rates = json_decode($value, true, 512, JSON_THROW_ON_ERROR);
            return InterestRateCollection::fromArray($rates);
        } catch (JsonException $e) {
            throw ConversionException::conversionFailed($value, $this->getName(), $e);
        }
    }

    /**
     * @param mixed $value
     * @throws ConversionException
     */
    #[Override]
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?string
    {
        $value = $value instanceof InterestRateCollection ? $value->getCollectionAsArray() : $value;
        if ($value === null) {
            return null;
        }

        try {
            return json_encode($value, JSON_THROW_ON_ERROR | JSON_PRESERVE_ZERO_FRACTION);
        } catch (JsonException $e) {
            throw ConversionException::conversionFailedSerialization($value, 'json', $e->getMessage(), $e);
        }
    }
}
