<?php

declare(strict_types=1);

namespace NowMe\Repository;

use NowMe\Entity\User;

interface UserRepository
{
    public function add(User $user): void;

    public function emailExist(string $email): bool;

    public function emailOrUsernameExist(string $email, string $username): bool;

    public function getByEmail(string $email): User;

    public function getByUsername(string $username): User;

    public function getByResetPasswordToken(string $token): User;

    public function getByConfirmEmailToken(string $token): User;

    public function allSpecialists(): array;

    public function getById(string $id): User;
}
