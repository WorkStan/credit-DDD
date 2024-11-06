<?php
declare(strict_types=1);

namespace App\Credit\Presentation\Controller\Product;

use App\Credit\Application\UseCase\CreateProduct\Dto;
use App\Credit\Application\UseCase\CreateProduct\Handler;
use App\Credit\Domain\Entity\Client\ClientId;
use App\Credit\Domain\Entity\Product\InterestRate;
use App\Credit\Domain\Entity\Product\InterestRateCollection;
use App\Credit\Domain\Entity\Product\LoanTerm;
use App\Credit\Domain\Entity\Product\ProductId;
use App\Credit\Domain\Entity\Product\ProductName;
use App\Credit\Domain\Enum\InterestRateKey;
use App\Credit\Domain\Enum\InterestRateType;
use App\Shared\Entity\Embeddable\Money;
use App\Shared\Enum\Currency;
use App\Shared\Service\UuidGeneratorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product', name: 'create.product', methods: ['POST'])]
class CreateProduct
{
    public function __construct(
        private UuidGeneratorInterface $uuidGenerator,
        private Handler $handler
    ) {}

    public function __invoke(
        #[MapRequestPayload]
        CreateProductDto $dto
    ): Response
    {
        $uuid = $this->uuidGenerator->generate();
        $dto = new Dto(
            id:  new ProductId($uuid),
            clientId:  new ClientId($dto->clientId),
            name: new ProductName($dto->name),
            loanTerm: new LoanTerm($dto->loanTerm),
            interestRates: new InterestRateCollection(
                new InterestRate(
                    InterestRateKey::Default,
                    InterestRateType::Add,
                    $dto->defaultInterestRate
                )
            ),
            money: new Money($dto->moneyAmount, 0, Currency::from($dto->moneyCurrency))
        );
        $this->handler->handle($dto);
        return new JsonResponse(['productId' => $uuid], Response::HTTP_CREATED);
    }
}
