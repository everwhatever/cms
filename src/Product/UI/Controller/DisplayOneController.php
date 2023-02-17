<?php

declare(strict_types=1);

namespace App\Product\UI\Controller;

use App\Product\Domain\Model\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayOneController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route(path: '/product/{id}', name: 'display_one_index')]
    public function displayOneAction(int $id): Response
    {
        $productRepository = $this->entityManager->getRepository(Product::class);
        $product = $productRepository->findOneBy(['id' => $id]);

        return $this->render('product/display_one.html.twig', [
            'product' => $product
        ]);
    }
}