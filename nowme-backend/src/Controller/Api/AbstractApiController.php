<?php

declare(strict_types=1);

namespace NowMe\Controller\Api;

use NowMe\Query\Api\Model\Error;
use NowMe\Query\Api\Model\Errors;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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

    protected function invalidFormValidationResponse(Errors $data): JsonResponse
    {
        return $this->json($data, Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    protected function getErrors(FormInterface $form): Errors
    {
        $errors = [];

        foreach ($form as $child) {
            /** @var FormError $error */
            foreach ($child->getErrors(true) as $error) {
                $errors[] = new Error($child->getName(), $error->getMessage());
            }
        }

        return new Errors($errors);
    }
}
