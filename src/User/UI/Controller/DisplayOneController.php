<?php

declare(strict_types=1);

namespace App\User\UI\Controller;

use App\User\Domain\Model\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayOneController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route(path: '/user/{id}', name: 'display_one_user_index')]
    public function displayOneAction(int $id): Response
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['id' => $id]);

        return $this->render('user/display_one.html.twig', [
            'user' => $user
        ]);
    }
}