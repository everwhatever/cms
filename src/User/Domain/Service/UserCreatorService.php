<?php

declare(strict_types=1);

namespace App\User\Domain\Service;

use App\User\Domain\Model\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserCreatorService
{
    public function __construct(private readonly EntityManagerInterface $entityManager, private readonly UserPasswordHasherInterface $passwordHasher, private readonly EventDispatcherInterface $eventDispatcher)
    {
    }

    public function createUser(string $email, string $plainPassword): User
    {
        $user = new User();
        $user->setEmail($email);
        $password = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

//        $this->sendVerificationEmail($email, (string) $user->getId());

        return $user;
    }

//    private function sendVerificationEmail(string $email, string $userId): void
//    {
//        $this->eventDispatcher->dispatch(new VerifyEmailEvent($email, $userId), VerifyEmailEvent::NAME);
//    }
}