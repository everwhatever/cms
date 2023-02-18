<?php

declare(strict_types=1);

namespace App\Blog\UI\Controller;

use App\Blog\Application\Message\Command\CreatePostMessage;
use App\Blog\Domain\Model\Post;
use App\Blog\Infrastructure\Form\CreatePostType;
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

    #[Route(path: '/post/create', name: 'post_create_index')]
    public function createAction(Request $request): Response
    {
        $form = $this->createForm(CreatePostType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $postId = $this->command($form->getData());

            return $this->redirectToRoute('display_one_post_index', ['id' => $postId]);
        }

        return $this->render('blog/create_post.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function command(Post $post): int
    {
        $message = new CreatePostMessage($post);
        $envelope = $this->commandBus->dispatch($message);
        $handleStamp = $envelope->last(HandledStamp::class);

        return $handleStamp->getResult();

    }
}