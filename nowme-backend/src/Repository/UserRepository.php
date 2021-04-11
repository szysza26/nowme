<?php

declare(strict_types=1);

namespace NowMe\Repository;

use NowMe\Model\User;

interface UserRepository
{
    public function add(User $user): void;

    public function emailExist(string $email): bool;

    public function getByEmail(string $email): User;

    public function getByResetPasswordToken(string $token): User;
}
