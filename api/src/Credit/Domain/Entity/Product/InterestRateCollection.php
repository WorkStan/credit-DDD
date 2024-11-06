<?php
declare(strict_types=1);

namespace App\Credit\Domain\Entity\Product;

use App\Credit\Domain\Enum\InterestRateKey;
use App\Credit\Domain\Enum\InterestRateType;
use App\Credit\Domain\Exception\InterestRateAlreadyExistException;
use App\Credit\Domain\Exception\InterestRateDoesNotExistException;

final class InterestRateCollection
{
    /** @var InterestRate[] $collection */
    private array $collection;

    public function __construct(
        InterestRate ...$interestRate
    ) {
        foreach ($interestRate as $rate) {
            $this->collection[$rate->key->value] = $rate;
        }
    }

    /** @param array<array<string, string|float>> $data */
    public static function fromArray(array $data): self
    {
        $interestRates = [];
        /** @var array<string, string|float> $item */
        foreach ($data as $item) {
            if (
                !array_key_exists('key', $item)
                || !array_key_exists('type', $item)
                || !array_key_exists('value', $item)
            ) {
                throw new \InvalidArgumentException();
            }
            $interestRates[] = new InterestRate(InterestRateKey::from($item['key']), InterestRateType::from($item['type']), $item['value']);
        }
        return new self(...$interestRates);
    }

    public function addInterestRate(InterestRate $interestRate): self
    {
        if ($this->hasInterestRate($interestRate)) {
            throw new InterestRateAlreadyExistException();
        }
        return new self($interestRate, ...$this->collection);
    }

    public function hasInterestRate(InterestRate $interestRate): bool
    {
        return array_key_exists($interestRate->key->value, $this->collection);
    }

    public function removeInterestRate(InterestRate $interestRate): self
    {
        if (!$this->hasInterestRate($interestRate)) {
            throw new InterestRateDoesNotExistException();
        }
        $newInterestRateCollection = clone $this;
        unset($newInterestRateCollection->collection[$interestRate->key->value]);
        return $newInterestRateCollection;
    }

    public function getTotalInterestRate(): float
    {
        $total = 0;
        foreach ($this->collection as $interestRate) {
            if ($interestRate->type === InterestRateType::Add) {
                $total += $interestRate->value;
            }
            if ($interestRate->type === InterestRateType::Sub) {
                $total -= $interestRate->value;
            }
        }
        return $total;
    }

    /** @return array<array<string, string|float>> */
    public function getCollectionAsArray(): array
    {
        $result = [];
        foreach ($this->collection as $interestRate) {
            $result[] = [
                'key' => $interestRate->key->value,
                'type' => $interestRate->type->value,
                'value' => $interestRate->value,
            ];
        }
        return $result;
    }

    public function __toString(): string
    {
        return json_encode($this->collection);
    }
}
