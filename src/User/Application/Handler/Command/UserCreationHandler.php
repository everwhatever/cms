<?php

declare(strict_types=1);

namespace App\User\Application\Handler\Command;

use App\User\Application\Message\Command\UserCreationMessage;
use App\User\Domain\Model\User;
use App\User\Domain\Service\UserCreatorService;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UserCreationHandler
{
    public function __construct(private readonly UserCreatorService $userCreator)
    {
    }

    public function __invoke(UserCreationMessage $message): User
    {
        return $this->userCreator->createUser($message->email, $message->plainPassword);
    }
}