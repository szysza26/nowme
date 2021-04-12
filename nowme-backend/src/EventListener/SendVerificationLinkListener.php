<?php

declare(strict_types=1);

namespace NowMe\EventListener;

use NowMe\Event\UserWasCreated;
use NowMe\Message\Security\SendVerificationLink;
use Symfony\Component\Messenger\MessageBusInterface;

final class SendVerificationLinkListener
{
    public function __construct(private MessageBusInterface $bus)
    {
    }
    
    public function __invoke(UserWasCreated $event): void
    {
        $this->bus->dispatch(new SendVerificationLink($event->username(), $event->email(), $event->token()));
    }
}
