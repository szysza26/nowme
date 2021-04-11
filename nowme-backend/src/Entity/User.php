<?php

declare(strict_types=1);

namespace NowMe\Entity;

final class User
{
    private string $username;
    private string $email;
    private string $password;
    private string $firstName;
    private string $lastName;
    private string $token;
    private string $emailConfirmToken;
    private ?\DateTimeImmutable $emailConfirmedAt = null;
    private ?string $resetPasswordToken = null;
    private \DateTimeImmutable $createdAt;

    public static function create(
        string $username,
        string $email,
        string $password,
        string $firstName,
        string $lastName,
        string $emailConfirmToken
    ): User {
        $self = new self();
        $self->username = $username;
        $self->email = $email;
        $self->password = $password;
        $self->firstName = $firstName;
        $self->lastName = $lastName;
        $self->emailConfirmToken = $emailConfirmToken;
        $self->createdAt = new \DateTimeImmutable();

        return $self;
    }

    public function setResetPasswordToken(string $token): void
    {
        $this->token = $token;
    }

    public function resetPassword(string $token, string $encodePassword): void
    {
        if ($token !== $this->resetPasswordToken) {
            throw new \InvalidArgumentException('Invalid reset password token');
        }

        $this->password = $encodePassword;
        $this->resetPasswordToken = null;
    }

    public function confirmEmail(string $token): void
    {
        if ($this->emailConfirmedAt !== null) {
            return;
        }

        if ($token !== $this->emailConfirmToken) {
            throw new \InvalidArgumentException('Invalid confirm e-mail token');
        }

        $this->emailConfirmedAt = new \DateTimeImmutable();
    }
}
