<?php

declare(strict_types=1);

namespace App\User\Application\Message\Command;

class UserCreationMessage
{
    public function __construct(public readonly string $email, public readonly string $plainPassword)
    {
    }
}