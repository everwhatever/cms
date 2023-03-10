<?php

declare(strict_types=1);

namespace App\Blog\Application\Message\Command;

use App\Blog\Domain\Model\Post;

class CreatePostMessage
{
    public function __construct(public readonly Post $post)
    {
    }
}
