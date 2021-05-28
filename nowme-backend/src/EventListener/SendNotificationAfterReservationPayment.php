<?php

declare(strict_types=1);

namespace NowMe\EventListener;

use NowMe\Event\ReservationWasPaid;
use NowMe\Repository\ReservationRepository;
use NowMe\Service\Notification\SMS\SMSNotification;

final class SendNotificationAfterReservationPayment
{
    public function __construct(
        private SMSNotification $notification,
        private ReservationRepository $reservationRepository
    ) {
    }

    public function __invoke(ReservationWasPaid $event): void
    {
        $reservation = $this->reservationRepository->find($event->reservationId());

        if (null === $reservation) {
            return;
        }

        if (null === $phoneNumber = $reservation->getUser()->phoneNumber()) {
            return;
        }

        $this->notification->sendReservationConfirmation($phoneNumber);
    }
}
