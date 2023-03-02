<?php

declare(strict_types=1);

namespace App\User\Application\Handler\Command;

use App\User\Application\Message\Command\UpdateUserInfoMessage;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;

#[AsMessageHandler]
class UpdateUserInfoHandler
{
    public function __construct(private readonly EntityManagerInterface $entityManager)
    {
    }

    public function __invoke(UpdateUserInfoMessage $userInfoMessage): int
    {
        $userAdditionalData = $userInfoMessage->userAdditionalInfo;
        $this->entityManager->persist($userAdditionalData);
        $this->entityManager->flush();

        return $userAdditionalData->getId();
    }
}