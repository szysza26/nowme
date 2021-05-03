<?php

namespace NowMe\Controller\Api;

use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManagerInterface;
use NowMe\Entity\Office;
use NowMe\Entity\Service;
use NowMe\Entity\User;
use NowMe\Form\Service\AddServiceForm;
use NowMe\Query\Api\Model\DictionaryService;
use NowMe\Repository\DoctrineORMOfficeRepository;
use NowMe\Repository\ServiceRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use NowMe\Repository\ServiceDictionaryRepository;

class ServiceController extends AbstractApiController
{
    private ServiceRepository $serviceRepository;
    private ServiceDictionaryRepository $serviceDictionaryRepository;

    public function __construct(ServiceRepository $serviceRepository, ServiceDictionaryRepository $serviceDictionaryRepository)
    {
        $this->serviceRepository = $serviceRepository;
        $this->serviceDictionaryRepository = $serviceDictionaryRepository;
    }

    #[Route('/services', name: 'list_services', methods: ['GET'])]
    public function index(Request $request): Response {
        $services = $this->getUser()->getServices();
        return $this->json($this->transformServices($services));
    }

    #[Route('/services/{id}', name: 'show_service', methods: ['GET'])]
    public function show(Request $request, int $id): Response {
        $service = $this->serviceRepository->find($id);
        return $this->json([
            "service" => [
                "id" => $service->getName()->id(),
                'name' => $service->getName()->name(),
            ],
            "price" => $service->getPrice(),
            "duration" => $service->getDuration()
        ]);
    }

    #[Route('/services', name: 'create_service', methods: ['POST'])]
    public function create(Request $request): Response {
        $form = $this->createForm(AddServiceForm::class);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        $service = new Service();
        $name = $this->serviceDictionaryRepository->find($form->get("name")->getData());
        $service
            ->setName($name)
            ->setPrice($form->get("price")->getData())
            ->setDuration($form->get("duration")->getData())
            ->setSpecialist($this->getUser());

        $this->serviceRepository->add($service);

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
        $name = $this->serviceDictionaryRepository->find($form->get("name")->getData());
        $service
            ->setName($name)
            ->setPrice($form->get("price")->getData())
            ->setDuration($form->get("duration")->getData());

        $this->serviceRepository->edit($service);

        return $this->json(['message' => 'ok']);
    }

    #[Route('/services/{id}', name: 'destroy_service', methods: ['DELETE'])]
    public function destroy(Request $request, int $id): Response {
        $service = $this->serviceRepository->find($id);

        $this->serviceRepository->delete($service);

        return $this->json(['message' => 'ok']);
    }

    private function transformServices(Collection $serviceslist): array
    {
        return array_map(
            static function (Service $service) {
                return [
                    'id' => $service->getId(),
                    "service" => [
                        "id" => $service->getName()->id(),
                        'name' => $service->getName()->name(),
                    ],
                    'price' => $service->getPrice(),
                    'duration' => $service->getDuration()
                ];
            },
            $serviceslist->toArray()
        );
    }
}
