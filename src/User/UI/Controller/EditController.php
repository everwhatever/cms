<?php

declare(strict_types=1);

namespace App\User\UI\Controller;

use App\User\Application\Message\Command\CreateUserMessage;
use App\User\Domain\Model\User;
use App\User\Infrastructure\Form\CreateUserType;
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

    #[Route(path: '/user/edit/{id}', name: 'user_edit_index')]
    public function editAction(Request $request, int $id): Response
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(CreateUserType::class, $user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->command($form->getData());

            return $this->redirectToRoute('display_one_user_index', ['id' => $user->getId()]);
        }

        return $this->render('user/create_user.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function command(User $user): void
    {
        $message = new CreateUserMessage($user);
        $this->commandBus->dispatch($message);
    }
}