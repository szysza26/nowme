<?php

declare(strict_types=1);

namespace NowMe\Controller\Api;

use NowMe\Entity\Reservation;
use NowMe\Entity\User;
use NowMe\Form\Reservation\CreateReservationForm;
use NowMe\Repository\ReservationRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

final class ReservationController extends AbstractApiController
{
    public function __construct(
        private Security $security,
        private ReservationRepository $reservationRepository
    ) {
    }

    #[Route('/reservations', name: 'reservations', methods: ['GET'])]
    public function list(): Response
    {
        /**
         * @var User $user
         */
        $user = $this->security->getUser();

        $reservations = $this->reservationRepository->findBy(['user' => $user]);

        return $this->json($this->transform($reservations));
    }

    #[Route('/reservations', name: 'reservation_create', methods: ['POST'])]
    public function create(
        Request $request
    ): Response {
        $form = $this->createForm(CreateReservationForm::class);

        $form->submit($this->parseJsonRequestContent($request));

        if (!$form->isValid()) {
            return $this->invalidFormValidationResponse($this->getErrors($form));
        }

        $data = [
            'service' => $form->get('service')->getData(),
            'office' => $form->get('office')->getData(),
            'specialist' => $form->get('specialist')->getData(),
            'reservation_date' => $form->get('reservation_date')->getData()
        ];

        $this->reservationRepository->add($this->createReservation($data));

        return $this->json(['message' => 'Reservation was created successfully']);
    }

    private function createReservation(array $data): Reservation
    {
        $startTime = \DateTimeImmutable::createFromFormat('Y-m-d H:i:s', $data['reservation_date']);
        $endTime = $startTime->add(new \DateInterval('PT15M'));

        $reservation = new Reservation();
        $reservation->setSpecialist($data['specialist']);
        $reservation->setOffice($data['office']);
        $reservation->setService($data['service']);
        $reservation->setDay($startTime);
        $reservation->setStartTime($startTime);
        $reservation->setEndTime($endTime);
        $reservation->setUser($this->security->getUser());

        return $reservation;
    }

    private function transform(array $reservations): array
    {
        return array_map(
            static function (Reservation $reservation) {
                return [
                    'specialist_id' => $reservation->getSpecialist()->id(),
                    'office_id' => $reservation->getOffice()->getId(),
                    'service_id' => $reservation->getService()->getId(),
                    'reservation_date' => $reservation->getDay()->format('Y-m-d'),
                    'reservation_hour_from' => $reservation->getStartTime()->format('H:i'),
                    'reservation_hour_to' => $reservation->getEndTime()->format('H:i'),
                ];
            },
            $reservations
        );
    }
}
