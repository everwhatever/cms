<?php

declare(strict_types=1);

namespace App\Product\UI\Controller;

use App\Product\Application\Message\Command\CreateProductMessage;
use App\Product\Domain\Model\Product;
use App\Product\Infrastructure\Form\CreateProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Routing\Annotation\Route;

class EditController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager,
                                private readonly MessageBusInterface $commandBus)
    {
    }

    #[Route(path: '/product/edit/{id}', name: 'product_edit_index')]
    public function editAction(Request $request, int $id): Response
    {
        $product = $this->entityManager->getRepository(Product::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(CreateProductType::class, $product);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->command($form->getData());

            return $this->redirectToRoute('display_one_index', ['id' => $product->getId()]);
        }

        return $this->render('product/create_product.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function command(Product $product): void
    {
        $message = new CreateProductMessage($product);
        $this->commandBus->dispatch($message);
    }
}