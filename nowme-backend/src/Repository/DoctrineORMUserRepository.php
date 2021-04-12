<?php

declare(strict_types=1);

namespace NowMe\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use NowMe\Entity\User;

final class DoctrineORMUserRepository implements UserRepository
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $objectManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->objectManager = $this->entityManager->getRepository(User::class);
    }

    public function add(User $user): void
    {
        $this->entityManager->persist($user);
    }

    public function emailExist(string $email): bool
    {
        $sql = "SELECT 1 FROM NowMe\Entity\User u WHERE u.email = :email";

        $result = $this->entityManager->createQuery($sql)
            ->setParameter('email', $email)
            ->setMaxResults(1)
            ->getResult();

        return !empty($result);
    }

    public function getByEmail(string $email): User
    {
        $user = $this->objectManager->findOneBy(['email' => $email]);

        if (!$user instanceof User) {
            throw new \InvalidArgumentException(sprintf('User with email %s not found', $email));
        }

        return $user;
    }

    public function getByResetPasswordToken(string $token): User
    {
        $user = $this->objectManager->findOneBy(['resetPasswordToken' => $token]);

        if (!$user instanceof User) {
            throw new \InvalidArgumentException(sprintf('User with reset password token %s not found', $token));
        }

        return $user;
    }

    public function getByConfirmEmailToken(string $token): User
    {
        $user = $this->objectManager->findOneBy(['emailConfirmToken' => $token]);

        if (!$user instanceof User) {
            throw new \InvalidArgumentException(sprintf('User with email confirm token %s not found', $token));
        }

        return $user;
    }
}
