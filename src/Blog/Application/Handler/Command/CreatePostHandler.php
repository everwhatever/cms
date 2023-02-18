<?php

declare(strict_types=1);

namespace App\Blog\Application\Handler\Command;

use App\Blog\Application\Message\Command\CreatePostMessage;
use App\Blog\Infrastructure\Repository\PostRepository;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class CreatePostHandler
{
    public function __construct(private readonly PostRepository $postRepository)
    {
    }

    public function __invoke(CreatePostMessage $message): int
    {
        $post = $message->post;
        $this->postRepository->save($post, true);

        return $post->getId();
    }
}
