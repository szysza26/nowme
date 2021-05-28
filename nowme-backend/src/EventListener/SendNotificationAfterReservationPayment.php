<?php

declare(strict_types=1);

namespace NowMe\EventListener;

use NowMe\Event\ReservationWasPaid;
use NowMe\Service\Notification\SMS\SMSNotification;

final class SendNotificationAfterReservationPayment
{
    public function __construct(private SMSNotification $notification)
    {
    }

    public function __invoke(ReservationWasPaid $event): void
    {
        $this->notification->sendReservationConfirmation($event->phoneNumber());
    }
}
