<?php

declare(strict_types=1);

namespace NowMe\MessageHandler\Security;

use NowMe\Message\Security\SendVerificationLink;
use NowMe\Service\Mailer\SecurityMailer;

final class SendVerificationLinkHandler
{
    public function __construct(private SecurityMailer $mailer)
    {
    }

    public function __invoke(SendVerificationLink $message): void
    {
        $this->mailer->sendVerificationLink($message->email(), $message->username(), $message->token());
    }
}
