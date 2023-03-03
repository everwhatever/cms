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
    public function thereIsAnAdminUserWithPassword($email, $password): User
    {
        $user = new User();
        $user->setEmail($email);
        $password = $this->passwordHasher->hashPassword($user, $password);
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        return $user;
    }

    /**
     * @Given I am logged in as an admin
     */
    public function iAmLoggedInAsAnAdmin()
    {
        $this->currentUser = $this->thereIsAnAdminUserWithPassword('admin@admin.pl', 'admin');
        $this->visitPath('/login');
        $this->getSession()->getPage()->fillField('Email', 'admin@admin.pl');
        $this->getSession()->getPage()->fillField('Hasło', 'admin');
        $this->getSession()->getPage()->pressButton('Zaloguj');
    }
}