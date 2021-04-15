<?php

namespace NowMe\Controller\Api;

use Doctrine\Persistence\ObjectManager;
use NowMe\Entity\Service;
use NowMe\Form\Service\AddServiceForm;
use NowMe\Repository\DoctrineORMOfficeRepository;
use NowMe\Repository\ServiceRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController extends AbstractController
{
    private ServiceRepository $serviceRepository;
    private ObjectManager $entityManager;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;
        $this->entityManager = $this->getDoctrine()->getManager();
    }

    #[Route('/services', name: 'list_services', methods: ['GET'])]
    public function index(Request $request): Response {
        $service = $this->serviceRepository->findAll();
        return $this->json($service);
    }

    #[Route('/services/{id}', name: 'show_service', methods: ['GET'])]
    public function show(Request $request, int $id): Response {
        $office = $this->serviceRepository->get($id);
        return $this->json($office);
    }

    #[Route('/services', name: 'create_service', methods: ['POST'])]
    public function create(Request $request): Response {
        $form = $this->createForm(AddSericeForm::class);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        $service = new Service();
        $service
            ->setName($form->get("name")->getData())
            ->setPrice($form->get("price")->getData())
            ->setDuration($form->get("duration")->getData())
            ->setSpecjalist($this->getUser())
            ->removeOffices();
        $officeRepository = new DoctrineORMOfficeRepository();
        foreach ($form->get("officeIds")->getData() as $officeId) {
            $service->addOffice($officeRepository->get($officeId));
        }

        $this->entityManager->persist($service);
        $this->entityManager->flush();

        return $this->json(['message' => 'ok']);
    }

    #[Route('/services/{id}', name: 'update_service', methods: ['PUT'])]
    public function update(Request $request, int $id): Response {
        $form = $this->createForm(AddServiceForm::class);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        $service = $this->serviceRepository->find($id);
        $service
            ->setName($form->get("name")->getData())
            ->setPrice($form->get("price")->getData())
            ->setDuration($form->get("duration")->getData())
            ->removeOffices();

        $officeRepository = new DoctrineORMOfficeRepository();
        foreach ($form->get("officeIds")->getData() as $officeId) {
            $service->addOffice($officeRepository->get($officeId));
        }

        $this->entityManager->persist($service);
        $this->entityManager->flush();

        return $this->json(['message' => 'ok']);
    }

    #[Route('/services/{id}', name: 'destroy_service', methods: ['DELETE'])]
    public function destroy(Request $request, int $id): Response {
        $service = $this->serviceRepository->get($id);
        $this->entityManager->remove($service);
        $this->entityManager->flush();

        return $this->json(['message' => 'ok']);
    }
}
