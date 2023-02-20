<?php

declare(strict_types=1);

namespace App\User\UI\Controller;

use App\User\Domain\Model\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route(path: '/user/delete/{id}', name: 'user_delete_index')]
    public function deleteAction(int $id): Response
    {
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['id' => $id]);

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->redirectToRoute('display_all_users_index');
    }
}