<?php
declare(strict_types=1);

namespace App\Credit\Domain\Entity\Dto;

use App\Credit\Domain\Entity\Client\ClientId;
use App\Credit\Domain\Entity\Product\InterestRateCollection;
use App\Credit\Domain\Entity\Product\LoanTerm;
use App\Credit\Domain\Entity\Product\ProductId;
use App\Credit\Domain\Entity\Product\ProductName;
use App\Shared\Entity\Embeddable\Money;

readonly class CreateProductDto
{
    public function __construct(
        public ProductId                $id,
        public ClientId                 $clientId,
        public ProductName              $name,
        public LoanTerm                 $loanTerm,
        public InterestRateCollection   $interestRates,
        public Money                    $money,
    ) {}
}
