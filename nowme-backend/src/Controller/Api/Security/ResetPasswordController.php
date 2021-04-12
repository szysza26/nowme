<?php

declare(strict_types=1);

namespace NowMe\Controller\Api\Security;

use NowMe\Controller\Api\AbstractApiController;
use NowMe\Controller\Api\Security\Model\ResetPasswordRequest;
use NowMe\Controller\Api\Security\Model\SendResetPasswordLinkRequest;
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
        $sendResetPasswordLinkRequest = new SendResetPasswordLinkRequest();
        $form = $this->createForm(SendResetPasswordLinkForm::class, $sendResetPasswordLinkRequest);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        $this->dispatchMessage(new SendResetPasswordLink($sendResetPasswordLinkRequest->email));

        return $this->json(['message' => 'An email has been sent to your address']);
    }

    #[Route('/reset-password/{token}', name: 'reset_password', methods: ['POST'])]
    public function resetPassword(
        Request $request,
        string $token
    ): Response {
        $resetPasswordRequest = new ResetPasswordRequest();

        $form = $this->createForm(ResetPasswordForm::class, $resetPasswordRequest);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        $this->dispatchMessage(new ResetPassword($token, $resetPasswordRequest->plainPassword));

        return $this->json(['message' => 'Your password has been changed, you can now log in']);
    }
}
