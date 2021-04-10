<?php

declare(strict_types=1);

namespace NowMe\Controller\Api\Security;

use NowMe\Controller\Api\AbstractApiController;
use NowMe\Form\Security\ResetPasswordForm;
use NowMe\Form\Security\SendResetPasswordLinkForm;
use NowMe\Message\Security\ResetPassword;
use NowMe\Message\Security\SendResetPasswordLink;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ResetPasswordController extends AbstractApiController
{
    #[Route('/reset-password', name: 'send_reset_password_link', methods: ['POST'])]
    public function sendResetPasswordLink(
        Request $request
    ): Response {
        $form = $this->createForm(SendResetPasswordLinkForm::class);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        $this->dispatchMessage(
            new SendResetPasswordLink(
                $form->get('email')->getData()
            )
        );

        return $this->json(['message' => 'An email has been sent to your address']);
    }

    #[Route('/reset-password/{token}', name: 'reset_password', methods: ['POST'])]
    public function resetPassword(
        Request $request
    ): Response {
        $form = $this->createForm(ResetPasswordForm::class);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        $this->dispatchMessage(
            new ResetPassword(
                $form->get('token')->getData(),
                $form->get('password')->getData()
            )
        );

        return $this->json(['message' => 'Your password has been changed, you can now log in']);
    }
}
