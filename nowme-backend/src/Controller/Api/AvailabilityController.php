<?php

namespace NowMe\Controller\Api;

use Doctrine\Common\Collections\Collection;
use NowMe\Entity\Availability;
use NowMe\Form\Availability\AddAvailabilityForm;
use NowMe\Repository\AvailabilityRepository;
use NowMe\Repository\OfficeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use NowMe\Entity\User;

class AvailabilityController extends AbstractApiController
{

    private AvailabilityRepository $availabilityRepository;
    private OfficeRepository $officeRepository;

    public function __construct(AvailabilityRepository $savailabilityRepository, OfficeRepository $officeRepository)
    {
        $this->availabilityRepository = $savailabilityRepository;
        $this->officeRepository = $officeRepository;
    }

    #[Route('/availabilities', name: 'list_availabilities', methods: ['GET'])]
    public function index(Request $request): Response {
        $availabilities = $this->getUser()->getAvailabilities();
        return $this->json($this->transformAvailabilities($availabilities));
    }


    #[Route('/availabilities/{id}', name: 'show_availability', methods: ['GET'])]
    public function show(Request $request, int $id): Response {
        $availability = $this->availabilityRepository->find($id);
        return $this->json($this->transformAvailability($availability));
    }

    #[Route('/availabilities', name: 'create_availability', methods: ['POST'])]
    public function create(Request $request): Response {
        $form = $this->createForm(AddAvailabilityForm::class);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        $office = $this->officeRepository->get($form->get("office")->getData());
        $availability = new Availability();
        $availability
            ->setDate(new \DateTime($form->get("date")->getData()))
            ->setHourFrom(new \DateTime($form->get("hour_from")->getData()))
            ->setHourTo(new \DateTime($form->get("hour_to")->getData()))
            ->setSpecjalist($this->getUser())
            ->setOffice($office);

        $this->availabilityRepository->add($availability);

        return $this->json(['message' => 'ok']);
    }

    #[Route('/availabilities/{id}', name: 'update_availability', methods: ['PUT'])]
    public function update(Request $request, int $id): Response {
        $form = $this->createForm(AddAvailabilityForm::class);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        $office = $this->officeRepository->get($form->get("office")->getData());
        $availability = $this->availabilityRepository->find($id);
        $availability
            ->setDate(new \DateTime($form->get("date")->getData()))
            ->setHourFrom(new \DateTime($form->get("hour_from")->getData()))
            ->setHourTo(new \DateTime($form->get("hour_to")->getData()))
            ->setOffice($office);

        $this->availabilityRepository->edit($availability);

        return $this->json(['message' => 'ok']);
    }

    #[Route('/availabilities/{id}', name: 'destroy_availability', methods: ['DELETE'])]
    public function destroy(Request $request, int $id): Response {
        $availability = $this->availabilityRepository->find($id);

        $this->availabilityRepository->delete($availability);

        return $this->json(['message' => 'ok']);
    }

    private function transformAvailability(Availability $availability)
    {
        return [
            'id' => $availability->getId(),
            "date" => $availability->getDate(),
            "hour_from" => $availability->getHourFrom(),
            "hour_to" => $availability->getHourTo(),
            "office_id" => $availability->getOffice()->getId(),
            "office_name" => $availability->getOffice()->getName(),
        ];
    }

    private function transformAvailabilities(Collection $availabilities): array
    {
        return array_map(
            static function (Availability $availability) {
                return [
                    'id' => $availability->getId(),
                    "date" => $availability->getDate(),
                    "hour_from" => $availability->getHourFrom(),
                    "hour_to" => $availability->getHourTo(),
                    "office_id" => $availability->getOffice()->getId(),
                    "office_name" => $availability->getOffice()->getName(),
                ];
            },
            $availabilities->toArray()
        );
    }
}
