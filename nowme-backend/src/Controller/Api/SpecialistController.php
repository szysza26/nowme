<?php

namespace NowMe\Controller\Api;

use Doctrine\ORM\EntityManagerInterface;
use NowMe\Entity\User;
use NowMe\Form\Specialist\CreateSpecialistForm;
use NowMe\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SpecialistController extends AbstractApiController
{
    public function __construct(private UserRepository $userRepository, private EntityManagerInterface $entityManager)
    {
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

        $this->userRepository
            ->getByUsername($form->get('username')->getData())
            ->changeRole($form->get('role')->getData());

        $this->entityManager->flush();

        return $this->json(['message' => 'Specialist role was assigned successfuly.']);
    }

    #[Route('/specialists', name: 'specialists', methods: ['GET'])]
    public function list(): Response
    {
        $specialists = $this->userRepository->all();

        return $this->json($this->transformSpecialists($specialists));
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
