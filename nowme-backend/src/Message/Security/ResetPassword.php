<?php

declare(strict_types=1);

namespace NowMe\Message\Security;

final class ResetPassword
{
    public function __construct(private string $token, private string $plainPassword)
    {
    }

    public function token(): string
    {
        return $this->token;
    }

    public function plainPassword(): string
    {
        return $this->plainPassword;
    }
}
