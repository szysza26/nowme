<?php

declare(strict_types=1);

namespace NowMe\Model;

final class User
{
    private string $username;
    private string $email;
    private string $password;
    private string $firstName;
    private string $lastName;
    private string $token;

    public static function create(
        string $username,
        string $email,
        string $password,
        string $firstName,
        string $lastName
    ): User {
        $self = new self();
        $self->username = $username;
        $self->email = $email;
        $self->password = $password;
        $self->firstName = $firstName;
        $self->lastName = $lastName;

        return $self;
    }

    public function setResetPasswordToken(string $token): void
    {
        $this->token = $token;
    }

    public function resetPassword(string $token, string $encodePassword): void
    {
    }
}
