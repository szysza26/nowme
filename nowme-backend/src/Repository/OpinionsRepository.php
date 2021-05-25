<?php

namespace NowMe\Repository;

use NowMe\Entity\Opinions;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Opinions|null find($id, $lockMode = null, $lockVersion = null)
 * @method Opinions|null findOneBy(array $criteria, array $orderBy = null)
 * @method Opinions[]    findAll()
 * @method Opinions[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class OpinionsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Opinions::class);
    }

    public function save(Opinions $opinion) : void
    {
        $this->getEntityManager()->persist($opinion);
        $this->getEntityManager()->flush();
    }

    public function delete(Opinions $opinion) : void
    {
        $this->getEntityManager()->remove($opinion);
        $this->getEntityManager()->flush();
    }

    public function getAllForSpecjalistId(int $specjalistId): array
    {
        $opinions = $this->findBy(['specjalist_id' => $specjalistId]);

        return $opinions;
    }
}
