<?php

namespace NowMe\Repository;

use NowMe\Entity\Service;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Service|null find($id, $lockMode = null, $lockVersion = null)
 * @method Service|null findOneBy(array $criteria, array $orderBy = null)
 * @method Service[]    findAll()
 * @method Service[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Service::class);
    }

    public function add(Service $service) : void
    {
        $this->getEntityManager()->persist($service);
        $this->getEntityManager()->flush();
    }

    public function edit(Service $service) : void
    {
        $this->getEntityManager()->persist($service);
        $this->getEntityManager()->flush();
    }

    public function delete(Service $service) : void
    {
        $this->getEntityManager()->remove($service);
        $this->getEntityManager()->flush();
    }
}
