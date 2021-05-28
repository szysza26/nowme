<?php

declare(strict_types=1);

namespace NowMe\Service\Notification\SMS;

use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\TexterInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

final class SymfonyNotifierSMSNotification implements SMSNotification
{
    public function __construct(private TexterInterface $texter, private TranslatorInterface $translator)
    {
    }

    public function sendReservationConfirmation(string $receiverPhoneNumber): void
    {
        $this->sendNotification(
            $receiverPhoneNumber,
            $this->translator->trans('sms.reservation_confirmation_message', [], 'notification')
        );
    }

    public function sendThanksForReservation(string $receiverPhoneNumber): void
    {
        $this->sendNotification(
            $receiverPhoneNumber,
            $this->translator->trans('sms.thanks_for_reservation_message', [], 'notification')
        );
    }

    private function sendNotification(string $receiverPhoneNumber, string $message): void
    {
        $this->texter->send(
            new SmsMessage(
                $receiverPhoneNumber,
                $message
            )
        );
    }
}
