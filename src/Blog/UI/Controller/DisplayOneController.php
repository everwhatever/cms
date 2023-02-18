<?php

declare(strict_types=1);

namespace App\Blog\UI\Controller;

use App\Blog\Domain\Model\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayOneController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route(path: '/post/{id}', name: 'display_one_index')]
    public function displayOneAction(int $id): Response
    {
        $postRepository = $this->entityManager->getRepository(Post::class);
        $post = $postRepository->findOneBy(['id' => $id]);

        return $this->render('blog/display_one.html.twig', [
            'post' => $post
        ]);
    }
}