<?php

declare(strict_types=1);

namespace NowMe\Controller\Api;

use NowMe\Entity\Office;
use NowMe\Entity\Reservation;
use NowMe\Entity\User;
use NowMe\Event\ReservationWasCreated;
use NowMe\Form\Reservation\CreateReservationForm;
use NowMe\Repository\ReservationRepository;
use NowMe\Service\PayU;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

use function Doctrine\ORM\QueryBuilder;

final class ReservationController extends AbstractApiController
{
    public function __construct(
        private Security $security,
        private ReservationRepository $reservationRepository,
        private PayU $payU,
        private EventDispatcherInterface $eventDispatcher
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

    #[Route('/reservations/{id}', name: 'reservation_delete', methods: ['DELETE'])]
    public function delete(
        Request $request,
        string $id
    ): Response {
        $reservation = $this->reservationRepository->find($id);

        if (null === $reservation) {
            return $this->json(['message' => 'Not found reservation.'], Response::HTTP_NOT_FOUND);
        }

        if ($reservation->getUser()->getUsername() !== $this->getUser()->getUsername()) {
            return $this->json(['message' => 'Not found reservation.'], Response::HTTP_NOT_FOUND);
        }

        $this->reservationRepository->remove($reservation);

        return $this->json(['message' => 'Reservation was removed successfully.']);
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

//        if ($this->checkIfDateIsReserved($data)) {
//            return $this->json(['message' => 'This date is reserved.'], Response::HTTP_CONFLICT);
//        }

        $reservation = $this->createReservation($data);

        $this->reservationRepository->add($reservation);

        $url = $this->payU->create($reservation);

        $this->eventDispatcher->dispatch(
            new ReservationWasCreated($this->getUser()->phoneNumber())
        );

        return $this->json(
            [
                'message' => 'Reservation was created successfully',
                'url' => $url
            ]
        );
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
            function (Reservation $reservation) {
                return [
                    'id' => $reservation->getId(),
                    'specialist' => [
                        'id' => $reservation->getSpecialist()->id(),
                        'name' => $reservation->getSpecialist()->fullName(),
                    ],
                    'office_address' => $this->transformOfficeAddress($reservation->getOffice()),
                    'service' => [
                        'id' => $reservation->getService()->getId(),
                        'name' => $reservation->getService()->getName()->name(),
                        'price' => $reservation->getService()->getPrice(),
                    ],
                    'reservation_date' => $reservation->getDay()->format('Y-m-d'),
                    'reservation_hour_from' => $reservation->getStartTime()->format('H:i'),
                    'reservation_hour_to' => $reservation->getEndTime()->format('H:i'),
                ];
            },
            $reservations
        );
    }

    private function transformOfficeAddress(Office $office): string
    {
        return \sprintf(
            '%s %s %s %s',
            $office->getStreet(),
            $office->getHouseNumber(),
            $office->getCity(),
            $office->getZip()
        );
    }

    private function checkIfDateIsReserved(array $data): bool
    {
        $date = new \DateTimeImmutable($data['reservation_date']);

        $qb = $this->reservationRepository->createQueryBuilder('r');

        $qb->where($qb->expr()->eq('r.day', ':date'))
            ->andWhere($qb->expr()->gte('r.startTime', ':start_time'))
            ->andWhere($qb->expr()->lte('r.endTime', ':end_time'))
            ->andWhere($qb->expr()->eq('r.specialist', ':specialist_id'))
            ->setParameters(
                [
                    'date' => $date->format('Y-m-d'),
                    'start_time' => $date->format('H:i:s'),
                    'end_time' => $date->add(new \DateInterval('PT15M'))->format('H:i:s'),
                    'specialist_id' => $data['specialist']
                ]
            );

        $result = $qb->getQuery()->execute();

        return !empty($result);
    }
}
