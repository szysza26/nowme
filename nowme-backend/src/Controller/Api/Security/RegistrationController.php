<?php

declare(strict_types=1);

namespace NowMe\Controller\Api\Security;

use NowMe\Controller\Api\AbstractApiController;
use NowMe\Form\Security\RegisterUserForm;
use NowMe\Message\Security\RegisterUser;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RegistrationController extends AbstractApiController
{
    #[Route('/register', name: 'register', methods: ['POST'])]
    public function __invoke(
        Request $request
    ): Response {

        $form = $this->createForm(RegisterUserForm::class);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
        }

        $this->dispatchMessage(
            new RegisterUser(
                $form->get('username')->getData(),
                $form->get('password')->getData(),
                $form->get('email')->getData(),
            )
        );
        return new JsonResponse('');
    }

}
