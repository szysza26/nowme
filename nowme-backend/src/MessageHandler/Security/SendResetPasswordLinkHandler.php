<?php

declare(strict_types=1);

namespace NowMe\MessageHandler\Security;

use NowMe\Message\Security\SendResetPasswordLink;
use NowMe\Service\Security\ResetPasswordTokenGenerator;
use Symfony\Component\Mailer\MailerInterface;

final class SendResetPasswordLinkHandler
{
    public function __construct(private MailerInterface $mailer, private ResetPasswordTokenGenerator $passwordTokenGenerator, private $users)
    {
        
    }
    public function __invoke(SendResetPasswordLink $message)
    {
        if (!$this->users->emailExist($message->email())) {
            return;
        }

        $token = $this->passwordTokenGenerator->generate();
        $this->users->getByEmail($message->email())->setResetPasswordToken($token);
        $this->mailer->send();
    }
}
