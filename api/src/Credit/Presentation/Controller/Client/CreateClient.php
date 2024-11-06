<?php
declare(strict_types=1);

namespace App\Credit\Presentation\Controller\Client;

use App\Credit\Application\UseCase\CreateClient\Dto;
use App\Credit\Application\UseCase\CreateClient\Handler;
use App\Credit\Domain\Entity\Client\Address;
use App\Credit\Domain\Entity\Client\Age;
use App\Credit\Domain\Entity\Client\ClientId;
use App\Credit\Domain\Entity\Client\ClientName;
use App\Credit\Domain\Entity\Client\FICO;
use App\Credit\Domain\Entity\Client\SSN;
use App\Shared\Entity\Embeddable\Money;
use App\Shared\Enum\State;
use App\Shared\Service\UuidGeneratorInterface;
use App\Shared\ValueObject\Email;
use App\Shared\ValueObject\PhoneNumber;
use App\Shared\ValueObject\ZIP;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/client', name: 'create.client', methods: ['POST'])]
class CreateClient
{
    public function __construct(
        private UuidGeneratorInterface $uuidGenerator,
        private Handler $handler
    ) {}
    public function __invoke(
        #[MapRequestPayload]
        CreateClientDto $dto
    ): Response
    {
        $uuid = $this->uuidGenerator->generate();
        $dto = new Dto(
            id:  new ClientId($uuid),
            name: new ClientName($dto->firstName, $dto->lastName),
            age: new Age($dto->age),
            address:  new Address(
                city: $dto->city,
                state: State::{$dto->state},
                zip: new ZIP($dto->zip)
            ),
            ssn: new SSN($dto->ssn),
            fico: new FICO($dto->fico),
            email: new Email($dto->email),
            phoneNumber: new PhoneNumber($dto->phoneCode, $dto->phoneNumber),
            income: new Money($dto->incomeUsdPerMonth)
        );
        $this->handler->handle($dto);
        return new JsonResponse(['clientId' => $uuid], Response::HTTP_CREATED);
    }
}
