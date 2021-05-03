<?php

namespace NowMe\Repository;

use NowMe\Entity\ServiceDictionary;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method ServiceDictionary|null find($id, $lockMode = null, $lockVersion = null)
 * @method ServiceDictionary|null findOneBy(array $criteria, array $orderBy = null)
 * @method ServiceDictionary[]    findAll()
 * @method ServiceDictionary[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class ServiceDictionaryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, ServiceDictionary::class);
    }
}
