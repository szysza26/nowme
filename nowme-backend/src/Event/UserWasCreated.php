<?php

declare(strict_types=1);

namespace NowMe\Event;

final class UserWasCreated
{
    public function __construct(private string $username, private string $email)
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
}
