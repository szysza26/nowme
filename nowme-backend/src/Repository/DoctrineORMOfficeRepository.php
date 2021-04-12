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
        $this->objectManager = $this->entityManager->getRepository(User::class);
    }

    public function add(Office $office): void
    {
        $this->entityManager->persist($office);
    }

    public function getByName(string $name): Office
    {
        $office = $this->objectManager->findOneBy(['name' => $name]);

        if (!$user instanceof Office) {
            throw new \InvalidArgumentException(sprintf('Office with name %s not found', $name));
        }

        return $office;
    }
}
