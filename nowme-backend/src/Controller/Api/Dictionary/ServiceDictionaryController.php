<?php

declare(strict_types=1);

namespace NowMe\Controller\Api\Dictionary;

use NowMe\Controller\Api\AbstractApiController;
use NowMe\Query\Api\Repository\ServiceDictionaryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ServiceDictionaryController extends AbstractApiController
{
    public function __construct(private ServiceDictionaryRepository $serviceDictionaryRepository)
    {
    }

    #[Route('/dictionaries/services', name: 'dictionary_services', methods: ['GET'])]
    public function list(): Response
    {
        $dictionaryServices = $this->serviceDictionaryRepository->all();

        return $this->json($dictionaryServices);
    }
}
