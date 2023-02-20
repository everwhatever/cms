<?php

declare(strict_types=1);

namespace App\User\UI\Controller;

use App\User\Application\Message\Command\UserCreationMessage;
use App\User\Domain\Model\User;
use App\User\Infrastructure\Form\RegisterType;
use App\User\Infrastructure\Security\SecurityAuthenticator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\HandledStamp;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

class RegistrationController extends AbstractController
{
    public function __construct(private readonly MessageBusInterface $commandBus, private readonly UserAuthenticatorInterface $authenticator, private readonly SecurityAuthenticator $securityAuthenticator)
    {
    }

    #[Route(path: '/register', name: 'register_index')]
    public function registerAction(Request $request): Response
    {
        $form = $this->createForm(RegisterType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();
            $user = $this->registerCommand($formData['email'], $formData['plainPassword']);

            return $this->authenticator->authenticateUser(
                $user,
                $this->securityAuthenticator,
                $request
            );
        }

        return $this->render('user/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    private function registerCommand(string $email, string $plainPassword): User
    {
        $message = new UserCreationMessage($email, $plainPassword);
        $envelope = $this->commandBus->dispatch($message);
        /** @var HandledStamp $handledStamp */
        $handledStamp = $envelope->last(HandledStamp::class);

        return $handledStamp->getResult();
    }
}