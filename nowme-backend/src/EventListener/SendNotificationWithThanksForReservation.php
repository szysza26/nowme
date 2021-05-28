<?php

declare(strict_types=1);

namespace NowMe\EventListener;

use NowMe\Event\ReservationWasCreated;
use NowMe\Service\Notification\SMS\SMSNotification;

final class SendNotificationWithThanksForReservation
{
    public function __construct(private SMSNotification $notification)
    {
    }

    public function __invoke(ReservationWasCreated $event): void
    {
        $this->notification->sendThanksForReservation($event->phoneNumber());
    }
}
