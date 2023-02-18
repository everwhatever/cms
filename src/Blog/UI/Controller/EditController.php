<?php

declare(strict_types=1);

namespace App\Blog\UI\Controller;


use App\Blog\Application\Message\Command\CreatePostMessage;
use App\Blog\Domain\Model\Post;
use App\Blog\Infrastructure\Form\CreatePostType;
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

    #[Route(path: '/post/edit/{id}', name: 'post_edit_index')]
    public function editAction(Request $request, int $id): Response
    {
        $post = $this->entityManager->getRepository(Post::class)->findOneBy(['id' => $id]);
        $form = $this->createForm(CreatePostType::class, $post);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->command($form->getData());

            return $this->redirectToRoute('display_one_post_index', ['id' => $post->getId()]);
        }

        return $this->render('blog/create_post.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function command(Post $post): void
    {
        $message = new CreatePostMessage($post);
        $this->commandBus->dispatch($message);
    }
}