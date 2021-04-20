<?php

declare(strict_types=1);

namespace NowMe\Controller\Api;

use Doctrine\Common\Collections\Collection;
use NowMe\Form\Office\AddOfficeForm;
use NowMe\Repository\OfficeRepository;
use NowMe\Entity\Office;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class OfficeController extends AbstractApiController
{
    private OfficeRepository $officeRepository;

    public function __construct(OfficeRepository $officeRepository)
    {
        $this->officeRepository = $officeRepository;
    }

    #[Route('/offices', name: 'list_offices', methods: ['GET'])]
    public function index(Request $request): Response {
        $offices = $this->officeRepository->all();
        return $this->json($this->transformOffices($offices));
    }

    #[Route('/offices/{id}', name: 'show_office', methods: ['GET'])]
    public function show(Request $request, int $id): Response {
        $office = $this->officeRepository->get($id);
        return $this->json($this->transformOffice($office));
    }

    #[Route('/offices', name: 'create_office', methods: ['POST'])]
    public function create(Request $request): Response {
        $form = $this->createForm(AddOfficeForm::class);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }
        

        $office = new Office();
        $office->setName($form->get("name")->getData());
        $office->setStreet($form->get("street")->getData());
        $office->setHouseNumber($form->get("houseNumber")->getData());
        $office->setCity($form->get("city")->getData());
        $office->setZip($form->get("zip")->getData());

        $this->officeRepository->add($office);

        return $this->json(['message' => 'ok']);
    }

    #[Route('/offices/{id}', name: 'update_office', methods: ['PUT'])]
    public function update(Request $request, int $id): Response {
        $form = $this->createForm(AddOfficeForm::class);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        $office = $this->officeRepository->get($id);

        $office->setName($form->get("name")->getData());
        $office->setStreet($form->get("street")->getData());
        $office->setHouseNumber($form->get("houseNumber")->getData());
        $office->setCity($form->get("city")->getData());
        $office->setZip($form->get("zip")->getData());

        $this->officeRepository->edit($office);

        return $this->json(['message' => 'ok']);
    }

    #[Route('/offices/{id}', name: 'destroy_office', methods: ['DELETE'])]
    public function destroy(Request $request, int $id): Response {
        $office = $this->officeRepository->get($id);
        $this->officeRepository->delete($office);

        return $this->json(['message' => 'ok']);
    }

    private function transformOffice(Office $office)
    {
        return [
            'id' => $office->getId(),
            'name' => $office->getName(),
            'street' => $office->getStreet(),
            'houseNumber' => $office->getHouseNumber(),
            'city' => $office->getCity(),
            'zip' => $office->getZip(),
        ];
    }

    private function transformOffices(array $offices): array
    {
        return array_map(
            static function (Office $office) {
                return [
                    'id' => $office->getId(),
                    'name' => $office->getName(),
                    'street' => $office->getStreet(),
                    'houseNumber' => $office->getHouseNumber(),
                    'city' => $office->getCity(),
                    'zip' => $office->getZip(),
                ];
            },
            $offices
        );
    }
}