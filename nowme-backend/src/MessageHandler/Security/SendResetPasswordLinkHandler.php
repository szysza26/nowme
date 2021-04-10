<?php

declare(strict_types=1);

namespace NowMe\MessageHandler\Security;

use NowMe\Message\Security\SendResetPasswordLink;
use NowMe\Security\ResetPasswordTokenGenerator;
use NowMe\Service\Mailer\SecurityMailer;

final class SendResetPasswordLinkHandler
{
    public function __construct(
        private SecurityMailer $mailer,
        private ResetPasswordTokenGenerator $passwordTokenGenerator,
        private $users
    ) {
    }

    public function __invoke(SendResetPasswordLink $message): void
    {
        if (!$this->users->emailExist($message->email())) {
            return;
        }

        $token = $this->passwordTokenGenerator->generate();
        $this->users->getByEmail($message->email())->setResetPasswordToken($token);

        $this->mailer->sendResetPasswordLink($message->email(), $token);
    }
}
