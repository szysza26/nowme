<?php

declare(strict_types=1);

namespace NowMe\Controller\Api\Security;

use NowMe\Controller\Api\AbstractApiController;
use NowMe\Controller\Api\Security\Model\RegisterRequest;
use NowMe\Form\Security\RegisterUserForm;
use NowMe\Message\Security\ConfirmEmail;
use NowMe\Message\Security\RegisterUser;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RegistrationController extends AbstractApiController
{
    #[Route('/register', name: 'register', methods: ['POST'])]
    public function register(
        Request $request
    ): Response {
        $registerRequest = new RegisterRequest();

        $form = $this->createForm(RegisterUserForm::class, $registerRequest);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        $this->dispatchMessage(
            new RegisterUser(
                $registerRequest->username,
                $registerRequest->plainPassword,
                $registerRequest->email,
                $registerRequest->firstName,
                $registerRequest->lastName,
            )
        );

        return $this->json(['message' => 'Your account has been created.']);
    }

    #[Route('/register/confirm/{token}', name: 'register_confirm', methods: ['POST'])]
    public function confirm(
        string $token
    ): Response {
        $this->dispatchMessage(new ConfirmEmail($token));

        return $this->json(['message' => 'E-mail address was confirmed.']);
    }
}
