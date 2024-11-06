<?php
declare(strict_types=1);

namespace App\Credit\Infrastructure\Doctrine\Types\Product;

use App\Credit\Domain\Entity\Product\LoanTerm;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Types\IntegerType;
use InvalidArgumentException;
use Override;

class LoanTermType extends IntegerType
{
    const NAME = 'loan_term';

    #[Override]
    public function getName(): string
    {
        return self::NAME;
    }

    #[Override]
    public function convertToPHPValue($value, AbstractPlatform $platform): ?LoanTerm
    {
        return !empty($value) ? new LoanTerm($value) : null;
    }

    /**
     * @param mixed $value
     */
    #[Override]
    public function convertToDatabaseValue($value, AbstractPlatform $platform): ?int
    {
        return $value instanceof LoanTerm ? $value->value : $value;
    }
}
