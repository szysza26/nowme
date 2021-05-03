<?php

declare(strict_types=1);

namespace NowMe\Controller\Api;

use NowMe\Form\Search\SearchSpecialistForm;
use NowMe\Query\Api\Repository\ServiceQueryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SearchController extends AbstractApiController
{
    public function __construct(private ServiceQueryRepository $serviceRepository)
    {
    }

    #[Route('/search', name: 'search', methods: ['POST'])]
    public function __invoke(
        Request $request
    ): Response {
        $form = $this->createForm(SearchSpecialistForm::class);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        $filters = [
            'date_from' => $form->get('dateFrom')->getData(),
            'date_to' => $form->get('dateTo')->getData(),
            'service' => $form->get('service')->getData(),
            'city' => $form->get('city')->getData()
        ];

        $services = $this->serviceRepository->findByFilter($filters);

        return $this->json($this->transformServices($services));
    }

    private function transformServices(array $services): array
    {
        return array_map(
            static function (array $service) {
                return [
                    'service' => $service['name_id'],
                    'office' => \sprintf(
                        '%s %s %s %s',
                        $service['zip'],
                        $service['city'],
                        $service['street'],
                        $service['house_number']
                    ),
                    'specialist' => \sprintf('%s %s', $service['first_name'], $service['last_name']),
                    'dateTime' => '',
                ];
            },
            $services
        );
    }
}
