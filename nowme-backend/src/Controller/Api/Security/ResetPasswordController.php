<?php

declare(strict_types=1);

namespace NowMe\Controller\Api\Security;

use NowMe\Controller\Api\AbstractApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ResetPasswordController extends AbstractApiController
{

    #[Route('/reset-password', name: 'send_reset_password_link', methods: ['POST'])]
    public function sendResetPasswordLink(
        Request $request
    ): Response {
        return new JsonResponse('');
    }

    #[Route('/reset-password/{token}', name: 'reset_password', methods: ['POST'])]
    public function resetPassword(
        Request $request
    ): Response {
        return new JsonResponse('');
    }
}
