<?php

declare(strict_types=1);

namespace NowMe\Repository;

use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectRepository;
use NowMe\Entity\Office;

final class DoctrineORMOfficeRepository implements OfficeRepository
{
    private EntityManagerInterface $entityManager;
    private ObjectRepository $objectManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->objectManager = $this->entityManager->getRepository(Office::class);
    }

    public function all(): array
    {
        return $this->objectManager->findAll();
    }

    public function get(int $id): Office
    {
        return $this->objectManager->find($id);
    }

    public function add(Office $office): void
    {
        $this->entityManager->persist($office);
        $this->entityManager->flush();
    }

    public function edit(Office $office): void
    {
        $this->entityManager->persist($office);
        $this->entityManager->flush();
    }

    public function delete(Office $office): void
    {
        $this->entityManager->remove($office);
        $this->entityManager->flush();
    }

    public function allById(array $offices): array
    {
        $qb = $this->entityManager->createQueryBuilder();

        $result = $qb->select('o')
            ->from(Office::class, 'o')
            ->where($qb->expr()->in('o.id', ':ids'))
            ->setParameters(['ids' => $offices])
            ->getQuery()
            ->getResult();

        return $result;
    }
}
