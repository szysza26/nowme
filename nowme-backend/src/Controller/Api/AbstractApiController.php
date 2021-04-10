<?php

declare(strict_types=1);

namespace NowMe\Controller\Api;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

abstract class AbstractApiController extends AbstractController
{
    protected function parseJsonRequestContent(Request $request): array
    {
        if ($request->getContent() === '') {
            return [];
        }

        try {
            $data = \json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            throw new BadRequestHttpException();
        }

        return $data;
    }

    protected function invalidFormValidationResponse($getErrorsFromForm)
    {
    }

    protected function getErrorsFromForm($form)
    {
    }
}
