<?php

namespace NowMe\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use NowMe\Entity\User;
use NowMe\Form\Specialist\CreateSpecialistForm;
use NowMe\Repository\OfficeRepository;
use NowMe\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Annotation\Route;

class SpecialistController extends AbstractApiController
{
    public function __construct(
        private UserRepository $userRepository,
        private EntityManagerInterface $entityManager,
        private OfficeRepository $officeRepository
    ) {
    }

    #[Route('/specialists', name: 'create_specialist', methods: ['POST'])]
    public function create(
        Request $request
    ): Response {
        $form = $this->createForm(CreateSpecialistForm::class);

        $data = $this->parseJsonRequestContent($request);

        $form->submit($data);

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        /**
         * @TODO Tak wiem to nie powinno byc w kontrolerze ale czas goni
         */
        $user = $this->userRepository
            ->getByUsername($form->get('username')->getData());

        $offices = $this->officeRepository->allById($form->get('offices')->getData());

        $user->setFirstName($form->get("first_name")->getData());
        $user->setLastName($form->get("last_name")->getData());
        $user->assignAs('ROLE_SPECIALIST');
        $user->assignOffices($offices);

        $this->entityManager->flush();

        return $this->json(['message' => 'Specialist role was assigned successfully.']);
    }

    #[Route('/specialists', name: 'specialists', methods: ['GET'])]
    public function list(): Response
    {
        $specialists = $this->userRepository->allSpecialists();

        return $this->json($this->transformSpecialists($specialists));
    }

    #[Route('/specialists/{specialistId}', name: 'show_specialist', methods: ['GET'])]
    public function show(string $specialistId): Response {
        $specialist = $this->userRepository->findBy($specialistId);

        if (null === $specialist) {
            throw new NotFoundHttpException();
        }

        return $this->json([
            'id' => $specialist->id(),
            'first_name' => $specialist->firstName(),
            'last_name' => $specialist->lastName(),
        ]);
    }

    #[Route('/specialists/{specialistId}', name: 'delete_specialist', methods: ['DELETE'])]
    public function deleteSpecialist(string $specialistId): Response {
        $user = $this->userRepository->findBy($specialistId);

        if (null === $user) {
            throw new NotFoundHttpException();
        }

        $this->entityManager->remove($user);
        $this->entityManager->flush();

        return $this->json(['message' => 'Specialist was deleted successfully.']);
    }

    /**
     * Tak wiem to można wydzielić do nowej klasy np SpecialistsTransformer
     */
    private function transformSpecialists(array $specialists): array
    {
        return array_map(
            static function (User $specialist) {
                return [
                    'id' => $specialist->id(),
                    'first_name' => $specialist->firstName(),
                    'last_name' => $specialist->lastName(),
                ];
            },
            $specialists
        );
    }
}
