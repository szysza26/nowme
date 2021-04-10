<?php

declare(strict_types=1);

namespace NowMe\Service\Mailer;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

final class SecurityMailer
{
    public function __construct(private string $sender, private MailerInterface $mailer)
    {
    }

    public function sendResetPasswordLink(string $email, string $token): void
    {
        $this->mailer->send(
            (new TemplatedEmail())->from(Address::create($this->sender))
                ->to($email)
                ->subject('Reset password to your NowMe account')
                ->htmlTemplate('emails/password-reset.html.twig')
                ->context(
                    [
                        'userEmail' => $email,
                        'token' => $token,
                    ]
                )
        );
    }

    public function sendVerificationLink(string $email, string $token): void
    {
        $this->mailer->send(
            (new TemplatedEmail())->from(Address::create($this->sender))
                ->to($email)
                ->subject('Verify your NowMe email address')
                ->htmlTemplate('emails/verification-link.html.twig')
                ->context(
                    [
                        'userEmail' => $email,
                        'token' => $token,
                    ]
                )
        );
    }
}
