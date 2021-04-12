<?php

declare(strict_types=1);

namespace NowMe\MessageHandler\Security;

use NowMe\Message\Security\ConfirmEmail;
use NowMe\Repository\UserRepository;

final class ConfirmEmailHandler
{
    public function __construct(private UserRepository $users)
    {
    }

    public function __invoke(ConfirmEmail $message): void
    {
        $this->users->getByConfirmEmailToken($message->token())->confirmEmail($message->token());
    }
}
