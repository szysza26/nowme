<?php

declare(strict_types=1);

namespace NowMe\Message\Security;

final class RegisterUser
{
    public function __construct(private string $username, private string $password, private string $email)
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

    public function password(): string
    {
        return $this->password;
    }
}
