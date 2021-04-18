<?php

namespace NowMe\Repository;

use NowMe\Entity\Availability;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Availability|null find($id, $lockMode = null, $lockVersion = null)
 * @method Availability|null findOneBy(array $criteria, array $orderBy = null)
 * @method Availability[]    findAll()
 * @method Availability[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AvailabilityRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Availability::class);
    }

    public function add(Availability $availability) : void
    {
        $this->getEntityManager()->persist($availability);
        $this->getEntityManager()->flush();
    }

    public function edit(Availability $availability) : void
    {
        $this->getEntityManager()->persist($availability);
        $this->getEntityManager()->flush();
    }

    public function delete(Availability $availability) : void
    {
        $this->getEntityManager()->remove($availability);
        $this->getEntityManager()->flush();
    }
}
