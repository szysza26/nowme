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

    public function add(Office $office): void
    {
        $this->entityManager->persist($office);
        $this->entityManager->flush();
    }

    public function all(): array
    {
        return $this->objectManager->findAll();
    }

    public function getByName(string $name): Office
    {
        $office = $this->objectManager->findOneBy(['name' => $name]);

        if (!$office instanceof Office) {
            throw new \InvalidArgumentException(sprintf('Office with name %s not found', $name));
        }

        return $office;
    }
}
