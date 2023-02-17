<?php

declare(strict_types=1);

namespace App\Product\Application\Handler\Command;

use App\Product\Application\Message\Command\CreateProductMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateProductHandler
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(CreateProductMessage $message): int
    {
        $product = $message->product;

        $this->entityManager->persist($product);
        $this->entityManager->flush();

        return $product->getId();
    }

}