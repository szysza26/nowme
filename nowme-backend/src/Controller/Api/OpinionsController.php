<?php

namespace NowMe\Controller\Api;

use NowMe\Entity\Opinions;
use NowMe\Form\Opinions\AddOpinionsType;
use NowMe\Repository\OpinionsRepository;
use \NowMe\Controller\Api\AbstractApiController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OpinionsController extends AbstractApiController
{
    private OpinionsRepository $opinionsRepository;
    private UserRepository $userRepository;

    public function __construct(OpinionsRepository $opinionsRepository)
    {
        $this->opinionsRepository = $opinionsRepository;
    }

    #[Route('/opinions', name: 'opinions')]
    public function index(Request $request): Response
    {
        $allOpinions = $this->opinionsRepository->findAll();

        return $this->json($this->transform($allOpinions));
    }

    #[Route('/opinions_average/{userId}', name: 'opinions_average')]
    public function average(Request $request, int $userId): Response
    {
        $allOpinions = $this->opinionsRepository->getAllForSpecjalistId($userId);
        $count = 0;
        $starsSum = 0;
        foreach ($allOpinions as $opinions) {
            $count++;
            $starsSum += $opinions->getStars();
        }

        $average = $starsSum / $count;

        return $this->json(['average' => $average]);
    }

    #[Route('/opinions/{id}', name: 'opinions_read')]
    public function read(Request $request, int $id): Response
    {
        $opinions = $this->opinionsRepository->find($id);

        return $this->json(
            [
                'id' => $opinions->getId(),
                'stars' => $opinions->getStars(),
                'content' => $opinions->getContent(),
                'user' => $opinions->getUser(),
                'specjalist' => $opinions->getSpecjalist()
            ]
        );
    }

    #[Route('/opinions/{id}', name: 'opinions_update', methods: ['PUT'])]
    public function update(Request $request, int $id): Response {
        $form = $this->createForm(AddOpinionsType::class);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        $opinions = $this->opinionsRepository->find($id);
        $opinions
            ->setStars($form->get("stars")->getData())
            ->setContent($form->get("content")->getData())
            ->setUser($form->get("user")->getData())
            ->setSpecjalist($form->get("specjalist")->getData());

        $this->opinionsRepository->save($opinions);

        return $this->json(['message' => 'ok']);
    }

    #[Route('/opinions', name: 'opinions_create', methods: ['POST'])]
    public function create(Request $request): Response {
        $form = $this->createForm(AddOpinionsType::class);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        $opinions = new Opinions();
        $opinions
            ->setStars($form->get("stars")->getData())
            ->setContent($form->get("content")->getData())
            ->setUser($form->get("user")->getData())
            ->setSpecjalist($form->get("specjalist")->getData());

        $this->opinionsRepository->save($opinions);

        return $this->json(['message' => 'ok']);
    }

    #[Route('/opinions/{id}', name: 'destroy_opinions', methods: ['DELETE'])]
    public function destroy(Request $request, int $id): Response {
        $opinions = $this->opinionsRepository->find($id);

        $this->opinionsRepository->delete($opinions);

        return $this->json(['message' => 'ok']);
    }

    private function transform(Collection $opinionsList): array
    {
        return array_map(
            static function (Opinions $opinions) {
                return [
                    'id' => $opinions->getId(),
                    'stars' => $opinions->getStars(),
                    'content' => $opinions->getContent(),
                    'user' => $opinions->getUser(),
                    'specjalist' => $opinions->getSpecjalist()
                ];
            },
            $opinionsList->toArray()
        );
    }
}
