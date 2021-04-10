<?php

declare(strict_types=1);

namespace NowMe\Controller\Api\Security;

use NowMe\Controller\Api\AbstractApiController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class RegistrationController extends AbstractApiController
{
//    public function __construct(private $formCreator)
//    {
//
//    }

    #[Route('/register', name: 'register', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        return new JsonResponse('');
    }

}
