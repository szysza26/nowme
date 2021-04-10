<?php

declare(strict_types=1);

namespace NowMe\Repository;

use NowMe\Entity\User;

interface UserRepository
{
    public function add(User $user): void;
}
