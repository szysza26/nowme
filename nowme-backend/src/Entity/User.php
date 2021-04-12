<?php

declare(strict_types=1);

namespace NowMe\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\GeneratedValue;

/**
 * @ORM\Entity
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @GeneratedValue
     */
    private int $id;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $username;

    /**
     * @ORM\Column(type="string", unique=true)
     */
    private string $email;
    /**
     * @ORM\Column(type="string")
     */
    private string $password;

    /**
     * @ORM\Column(type="string", length=30)
     */
    private string $firstName;

    /**
     * @ORM\Column(type="string", length=60)
     */
    private string $lastName;

    /**
     * @ORM\Column(type="string", length=512, unique=true, nullable=true)
     */
    private ?string $emailConfirmToken;

    /**
     * @ORM\Column(type="datetime_immutable", nullable=true)
     */
    private ?\DateTimeImmutable $emailConfirmedAt = null;

    /**
     * @ORM\Column(type="string", length=512, nullable=true, unique=true)
     */
    private ?string $resetPasswordToken = null;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
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

    public function id(): int
    {
        return $this->id;
    }

    public function setResetPasswordToken(string $resetPasswordToken): void
    {
        $this->resetPasswordToken = $resetPasswordToken;
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

        $this->emailConfirmToken = null;
        $this->emailConfirmedAt = new \DateTimeImmutable();
    }
}
