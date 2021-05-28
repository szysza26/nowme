<?php

declare(strict_types=1);

namespace NowMe\Service\Notification\SMS;

interface SMSNotification
{
    public function sendReservationConfirmation(string $receiverPhoneNumber): void;

    public function sendThanksForReservation(string $receiverPhoneNumber): void;
}
