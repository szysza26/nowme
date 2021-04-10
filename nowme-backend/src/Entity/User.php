<?php

declare(strict_types=1);

namespace NowMe\Entity;

final class User
{
    private string $username;
    private string $email;
    private string $password;

    public static function create(string $username, string $email, string $password): User
    {
        $self = new self();
        $self->username = $username;
        $self->email = $email;
        $self->password = $password;

        return $self;
    }
}
