<?php

declare(strict_types=1);

namespace NowMe\MessageHandler\Security;

use NowMe\Message\Security\ConfirmEmail;

final class ConfirmEmailHandler
{
    public function __invoke(ConfirmEmail $message): void
    {
    }
}
