<?php

declare(strict_types=1);

namespace App\Blog\UI\Controller;

use App\Blog\Domain\Model\Post;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DisplayAllController extends AbstractController
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    #[Route(path: '/', name: 'display_all_index')]
    public function displayAllAction(): Response
    {
        $postRepository = $this->entityManager->getRepository(Post::class);
        $posts = $postRepository->findAll();

        return $this->render('blog/display_all.html.twig', [
            'posts' => $posts
        ]);
    }
}