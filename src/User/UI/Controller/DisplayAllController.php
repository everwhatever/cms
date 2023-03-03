<?php

declare(strict_types=1);

namespace App\User\UI\Controller;

use App\User\Domain\Model\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class DisplayAllController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route(path: '/users', name: 'display_all_users_index')]
    #[IsGranted("ROLE_ADMIN")]
    public function displayAllAction(): Response
    {
        $userRepository = $this->entityManager->getRepository(User::class);
        $users = $userRepository->findAll();

        return $this->render('user/display_all.html.twig', [
            'users' => $users
        ]);
    }
}