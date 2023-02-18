<?php

declare(strict_types=1);

namespace App\Product\UI\Controller;

use App\Product\Domain\Model\Product;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route(path: '/product/delete/{id}', name: 'product_delete_index')]
    public function deleteAction(int $id): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBy(['id' => $id]);

        $this->entityManager->remove($product);
        $this->entityManager->flush();

        return $this->redirectToRoute('display_all_products_index');
    }
}