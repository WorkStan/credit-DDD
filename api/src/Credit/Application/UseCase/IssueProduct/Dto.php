<?php
declare(strict_types=1);

namespace App\Credit\Application\UseCase\IssueProduct;

use App\Credit\Domain\Entity\Product\ProductId;

final readonly class Dto
{
    public function __construct(
        public ProductId $id,
    ) {}
}
