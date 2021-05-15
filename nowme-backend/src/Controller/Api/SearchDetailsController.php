<?php

declare(strict_types=1);

namespace NowMe\Controller\Api;

use DateInterval;
use DatePeriod;
use DateTime;
use NowMe\Form\Search\SearchDetailsForm;
use NowMe\Query\Api\Repository\ServiceQueryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class SearchDetailsController extends AbstractApiController
{
    public function __construct(private ServiceQueryRepository $serviceRepository)
    {
    }

    #[Route('/search/details', name: 'search_details', methods: ['POST'])]
    public function __invoke(
        Request $request
    ): Response {
        $form = $this->createForm(SearchDetailsForm::class);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        $filters = [
            'date_from' => $form->get('dateFrom')->getData(),
            'date_to' => $form->get('dateTo')->getData(),
            'service' => $form->get('service')->getData(),
            'specialist' => $form->get('specialist')->getData(),
            'office' => $form->get('office')->getData()
        ];

        $availabilities = $this->serviceRepository->details($filters);

        return $this->json($this->createRanges($availabilities));
    }

    private function createRanges(array $availabilities): array
    {
        $tmp = [];

        foreach ($availabilities as $availability) {
            $start = new DateTime(\sprintf('%s %s', $availability['date'], $availability['hour_from']));
            $end = new DateTime(\sprintf('%s %s', $availability['date'], $availability['hour_to']));
            $interval = new DateInterval("PT15M");
            $range = new DatePeriod($start, $interval, $end);

            foreach ($range as $date) {
                $tmp[$availability['date']][] = $date->format("H:i:s");
            }
        }

        return $tmp;
    }
}
