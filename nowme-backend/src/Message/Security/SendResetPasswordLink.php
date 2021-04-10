<?php

declare(strict_types=1);

namespace NowMe\Message\Security;

final class SendResetPasswordLink
{
    public function __construct(private string $email)
    {
    }

    public function email(): string
    {
        return $this->email;
    }
}
