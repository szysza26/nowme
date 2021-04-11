<?php

declare(strict_types=1);

namespace NowMe\Message\Security;

final class ConfirmEmail
{
    public function __construct(private string $token)
    {
    }

    public function token(): string
    {
        return $this->token;
    }
}
