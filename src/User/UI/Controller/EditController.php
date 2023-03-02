<?php

declare(strict_types=1);

namespace App\User\UI\Controller;

use App\User\Application\Message\Command\UpdateUserInfoMessage;
use App\User\Domain\Model\UserAdditionalInfo;
use App\User\Infrastructure\Form\UserAdditionalInfoType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
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
        $userData = $this->entityManager->getRepository(UserAdditionalInfo::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(UserAdditionalInfoType::class, $userData);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userDataId = $this->command($form->getData());

            return $this->redirectToRoute('display_one_user_index', ['id' => $userDataId]);
        }

        return $this->render('user/update_user_info.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function command(UserAdditionalInfo $additionalInfo): int
    {
        $message = new UpdateUserInfoMessage($additionalInfo);
        $envelope = $this->commandBus->dispatch($message);

        return $envelope->last(HandledStamp::class)->getResult();
    }
}