<?php

declare(strict_types=1);

namespace App\Tests\Behat\User;

use App\User\Domain\Model\User;
use Behat\Behat\Context\Context;
use Behat\MinkExtension\Context\MinkContext;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AuthenticationContext extends MinkContext implements Context
{

    private User $currentUser;

    public function __construct(private readonly EntityManagerInterface      $entityManager,
                                private readonly UserPasswordHasherInterface $passwordHasher)
    {
    }

    /**
     * @BeforeScenario
     */
    public function clearData()
    {
        $purger = new ORMPurger($this->entityManager);
        $purger->purge();
    }

    /**
     * @Given there is an admin user with email :email and password :password
     */
    public function thereIsAnAdminUserWithPassword(string $email, string $password): User
    {
        $user = $this->createUser($email, $password);
        $user->setRoles(['ROLE_ADMIN']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @Given there is a user with email :email and password :password
     */
    public function thereIsAUserUserWithPassword(string $email, string $password): User
    {
        $user = $this->createUser($email, $password);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @Given I am logged in as a user
     */
    public function iAmLoggedInAsAUser()
    {
        $this->currentUser = $this->thereIsAUserUserWithPassword('user@user.pl', 'password');
        $this->login('password');
    }

    /**
     * @Given I am logged in as an admin
     */
    public function iAmLoggedInAsAnAdmin()
    {
        $this->currentUser = $this->thereIsAnAdminUserWithPassword('user@user.pl', 'admin');
        $this->login('admin');
    }

    private function login(string $password): void
    {
        $this->visitPath('/login');
        $this->getSession()->getPage()->fillField('Email', 'user@user.pl');
        $this->getSession()->getPage()->fillField('Hasło', $password);
        $this->getSession()->getPage()->pressButton('Zaloguj');
    }

    private function createUser(string $email, string $password): User
    {
        $user = new User();
        $user->setEmail($email);
        $password = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($password);

        return $user;
    }
}