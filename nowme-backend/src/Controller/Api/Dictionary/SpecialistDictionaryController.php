<?php

declare(strict_types=1);

namespace NowMe\Controller\Api\Dictionary;

use NowMe\Controller\Api\AbstractApiController;
use NowMe\Query\Api\Repository\SpecialistDictionaryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SpecialistDictionaryController extends AbstractApiController
{
    public function __construct(private SpecialistDictionaryRepository $specialistDictionaryRepository)
    {
    }

    #[Route('/dictionaries/specialists', name: 'dictionary_specialist', methods: ['GET'])]
    public function list(): Response
    {
        $dictionaryServices = $this->specialistDictionaryRepository->all();

        return $this->json($dictionaryServices);
    }
}
