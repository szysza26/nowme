<?php

declare(strict_types=1);

namespace NowMe\Controller\Api;

use NowMe\Controller\Api\AbstractApiController;
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

        return $this->json([$office]);
    }

    #[Route('/offices', name: 'office_list', methods: ['GET'])]
    public function index(Request $request): Response {
        $offices = $this->officeRepository->all();

        return $this->json([$offices]);
    }
}