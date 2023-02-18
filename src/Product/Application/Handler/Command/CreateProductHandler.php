<?php

declare(strict_types=1);

namespace App\Product\Application\Handler\Command;

use App\Product\Application\Message\Command\CreateProductMessage;
use App\Product\Infrastructure\Repository\ProductRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreateProductHandler
{
    public function __construct(private readonly ProductRepository $productRepository)
    {
    }

    public function __invoke(CreateProductMessage $message): int
    {
        $product = $message->product;
        $this->productRepository->save($product, true);

        return $product->getId();
    }

}