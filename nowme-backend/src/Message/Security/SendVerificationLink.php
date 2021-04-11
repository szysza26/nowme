<?php

declare(strict_types=1);

namespace NowMe\Message\Security;

final class SendVerificationLink
{
    public function __construct(private string $username, private string $email, private string $token)
    {
    }

    public function username(): string
    {
        return $this->username;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function token(): string
    {
        return $this->token;
    }
}
