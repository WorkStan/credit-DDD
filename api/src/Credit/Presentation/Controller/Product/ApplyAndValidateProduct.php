<?php
declare(strict_types=1);

namespace App\Credit\Presentation\Controller\Product;

use App\Credit\Application\UseCase\ApplyAndValidateProduct\Dto;
use App\Credit\Application\UseCase\ApplyAndValidateProduct\Handler;
use App\Credit\Application\UseCase\GetProduct\Dto as GetProductDto;
use App\Credit\Application\UseCase\GetProduct\Finder as GetProductFinder;
use App\Credit\Domain\Entity\Product\ProductId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product/apply-validate/{uuid}', name: 'apply_and_validate.product', methods: ['GET'])]
class ApplyAndValidateProduct
{
    public function __construct(
        private Handler $handler,
        private GetProductFinder $productFinder,
    ) {}

    public function __invoke(
        string $uuid,
    ): Response
    {
        $productId = new ProductId($uuid);
        $dto = new Dto($productId);
        $this->handler->handle($dto);
        $status = $this->productFinder->find(new GetProductDto($productId))->getStatus()->value;
        return new JsonResponse(['productId' => $uuid, 'status' => $status], Response::HTTP_CREATED);
    }
}
