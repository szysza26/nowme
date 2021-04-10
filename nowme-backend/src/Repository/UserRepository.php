<?php

declare(strict_types=1);

namespace NowMe\Repository;

use NowMe\Model\User;

interface UserRepository
{
    public function add(User $user): void;
}
