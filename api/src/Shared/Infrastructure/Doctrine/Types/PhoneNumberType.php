<?php
declare(strict_types=1);

namespace App\Shared\Infrastructure\Doctrine\Types;

use App\Shared\ValueObject\PhoneNumber;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\JsonType;
use JsonException;
use Override;

class PhoneNumberType extends JsonType
{
    const NAME = 'phone_number';

    public function getName(): string
    {
        return self::NAME;
    }

    #[Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): ?PhoneNumber
    {
        if (empty($value)) {
            return null;
        }
        $values = json_decode($value, true);
        return new PhoneNumber($values[0], $values[1]);
    }

    /**
     * @param mixed $value
     * @throws JsonException
     */
    #[Override]
    public function convertToDatabaseValue($value, AbstractPlatform $platform): string
    {
        if ($value instanceof PhoneNumber) {
            return json_encode([$value->countryCode, $value->number], JSON_THROW_ON_ERROR);
        }
        return $value;
    }
}
