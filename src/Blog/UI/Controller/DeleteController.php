<?php

declare(strict_types=1);

namespace App\Blog\UI\Controller;

use App\Blog\Domain\Model\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DeleteController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route(path: '/post/delete/{id}', name: 'post_delete_index')]
    public function deleteAction(int $id): Response
    {
        $post = $this->entityManager->getRepository(Post::class)->findOneBy(['id' => $id]);

        $this->entityManager->remove($post);
        $this->entityManager->flush();

        return $this->redirectToRoute('display_all_index');
    }
}