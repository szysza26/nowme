<?php

declare(strict_types=1);

namespace NowMe\Repository;

use Doctrine\ORM\EntityManagerInterface;
use NowMe\Model\User;

final class DoctrineORMUserRepository implements UserRepository
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
    }

    public function add(User $user): void
    {
        $this->entityManager->persist($user);
    }
}
