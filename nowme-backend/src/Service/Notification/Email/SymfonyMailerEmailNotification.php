<?php

declare(strict_types=1);

namespace NowMe\Service\Notification\Email;

use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;

final class SymfonyMailerEmailNotification implements EmailNotification
{
    public function __construct(private MailerInterface $mailer)
    {
    }

    public function send()
    {
        $this->mailer->send(
            (new TemplatedEmail())
                ->from(Address::create($this->sender))
                ->to($email)
                ->subject(sprintf('You\'ve been invited to %s organization', $organizationName))
                ->htmlTemplate('emails/organization-invitation.html.twig')
                ->context(
                    [
                        'userEmail' => $email,
                        'token' => $token,
                        'organizationName' => $organizationName,
                    ]
                )
        );
    }
}
