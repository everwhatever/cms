<?php

declare(strict_types=1);

namespace App\Product\UI\Controller;

use App\Product\Domain\Model\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayAllController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route(path: '/', name: 'display_all_products_index')]
    public function displayAllAction(): Response
    {
        $productRepository = $this->entityManager->getRepository(Product::class);
        $products = $productRepository->findAll();

        return $this->render('product/display_all.html.twig', [
            'products' => $products
        ]);
    }
}