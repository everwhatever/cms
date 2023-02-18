<?php

declare(strict_types=1);

namespace App\Product\UI\Controller;

use App\Product\Application\Message\Command\CreateProductMessage;
use App\Product\Domain\Model\Product;
use App\Product\Infrastructure\Form\CreateProductType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;

class CreateController extends AbstractController
{
    public function __construct(private readonly MessageBusInterface $commandBus)
    {
    }

    #[Route(path: '/product/create', name: 'product_create_index')]
    public function createAction(Request $request): Response
    {
        $form = $this->createForm(CreateProductType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $productId = $this->command($form->getData());

            return $this->redirectToRoute('display_one_product_index', ['id' => $productId]);
        }

        return $this->render('product/create_product.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function command(Product $product): int
    {
        $message = new CreateProductMessage($product);
        $envelope = $this->commandBus->dispatch($message);
        $handleStamp = $envelope->last(HandledStamp::class);

        return $handleStamp->getResult();

    }
}