<?php
declare(strict_types=1);

namespace App\Credit\Presentation\Controller\Product;

use App\Credit\Application\UseCase\IssueProduct\Dto;
use App\Credit\Application\UseCase\IssueProduct\Handler;
use App\Credit\Domain\Entity\Product\ProductId;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/product/issue/{uuid}', name: 'issue.product', methods: ['GET'])]
class IssueProduct
{
    public function __construct(
        private Handler $handler,
    ) {}

    public function __invoke(
        string $uuid,
    ): Response
    {
        $productId = new ProductId($uuid);
        $dto = new Dto($productId);
        $this->handler->handle($dto);
        return new JsonResponse(['productId' => $uuid], Response::HTTP_OK);
    }
}
