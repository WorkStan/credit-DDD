<?php

namespace App\Credit\Application\Subscribers;

use App\Credit\Domain\Entity\Product\ProductId;
use App\Credit\Domain\Enum\ProductStatus;
use App\Credit\Domain\Event\Product\ProductStatusChangedEvent;
use App\Credit\Domain\Repository\ClientRepositoryInterface;
use App\Credit\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Infrastructure\EventSubscriber\DefaultEventSubscriber;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

final class ProductSubscriber extends DefaultEventSubscriber
{
    public function __construct(
        private MailerInterface $mailer,
        private ProductRepositoryInterface $productRepository,
        private ClientRepositoryInterface $clientRepository
    ) {}

    public static function getSubscribedEvents(): array
    {
        return [
            ProductStatusChangedEvent::class => 'onProductStatusChanged',
        ];
    }

    /**
     * @throws TransportExceptionInterface
     */
    public function onProductStatusChanged(ProductStatusChangedEvent $event): void
    {
        if ($event->newStatus === ProductStatus::Issued) {
            $this->sendMail($event->productId);
        }
    }

    /**
     * @throws TransportExceptionInterface
     */
    private function sendMail(ProductId $productId): void
    {
        $product = $this->productRepository->findById($productId);
        $percent = $product->getTotalInterestRate();
        $client = $this->clientRepository->findById($product->getClientId());
        $email = $client->getEmail()->value;

        $email = (new Email())
            ->from('test@test.test')
            ->to($email)
            ->subject('Credit was issued!')
            ->text("Credit was issued for $percent% per year");

        $this->mailer->send($email);
    }
}
