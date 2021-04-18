<?php

namespace NowMe\Controller\Api;

use NowMe\Entity\Availability;
use NowMe\Form\Availability\AddAvailabilityForm;
use NowMe\Repository\AvailabilityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use NowMe\Entity\User;

class AvailabilityController extends AbstractApiController
{

    private AvailabilityRepository $availabilityRepository;

    public function __construct(AvailabilityRepository $savailabilityRepository)
    {
        $this->availabilityRepository = $savailabilityRepository;
    }

    #[Route('/availabilities', name: 'list_availabilities', methods: ['GET'])]
    public function index(Request $request): Response {
        $availabilities = $this->getUser()->getAvailabilities();
        return $this->json($availabilities);
    }


    #[Route('/availability/{id}', name: 'show_availability', methods: ['GET'])]
    public function show(Request $request, int $id): Response {
        $availability = $this->availabilityRepository->find($id);
        return $this->json([
            "date" => $availability->getDate(),
            "hour_from" => $availability->getHourFrom(),
            "hour_to" => $availability->getHourTo(),
            "office" => $availability->getOffice()
        ]);
    }

    #[Route('/availability', name: 'create_availability', methods: ['POST'])]
    public function create(Request $request): Response {
        $form = $this->createForm(AddAvailabilityForm::class);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        $availability = new Availability();
        $availability
            ->setDate($form->get("date")->getData())
            ->setHourFrom($form->get("hour_from")->getData())
            ->setHourTo($form->get("hour_to")->getData())
            ->setSpecjalist($this->getUser())
            ->setOffice($form->get("office")->getData());

        $this->availabilityRepository->add($availability);

        return $this->json(['message' => 'ok']);
    }

    #[Route('/availability/{id}', name: 'update_availability', methods: ['PUT'])]
    public function update(Request $request, int $id): Response {
        $form = $this->createForm(AddAvailabilityForm::class);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        $availability = $this->availabilityRepository->find($id);
        $availability
            ->setHourFrom($form->get("hour_from")->getData())
            ->setHourTo($form->get("hour_to")->getData())
            ->setOffice($form->get("office")->getData());

        $this->availabilityRepository->edit($availability);

        return $this->json([
            "date" => $availability->getDate(),
            "hour_from" => $availability->getHourFrom(),
            "hour_to" => $availability->getHourTo(),
            "office" => $availability->getOffice()
        ]);
    }

    #[Route('/availability/{id}', name: 'destroy_availability', methods: ['DELETE'])]
    public function destroy(Request $request, int $id): Response {
        $availability = $this->availabilityRepository->find($id);

        $this->availabilityRepository->delete($availability);

        return $this->json(['message' => 'ok']);
    }
}
