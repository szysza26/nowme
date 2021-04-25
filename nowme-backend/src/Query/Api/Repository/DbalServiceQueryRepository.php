<?php

declare(strict_types=1);

namespace NowMe\Query\Api\Repository;

use Doctrine\DBAL\Connection;

final class DbalServiceQueryRepository implements ServiceQueryRepository
{
    public function __construct(private Connection $connection)
    {
    }

    public function findByFilter(array $filters): array
    {
        $qb = $this->connection->createQueryBuilder();

        $qb->select(
            [
                'u.id',
                'u.first_name',
                'u.last_name',
                'o.city',
                'o.street',
                'o.house_number',
                'o.zip',
                's.name'
            ]
        )
            ->from('service', 's')
            ->leftJoin('s', 'user', 'u', 's.specialist_id = u.id')
            ->leftJoin('u', 'user_office', 'uf', 'u.id = uf.user_id')
            ->leftJoin('uf', 'office', 'o', 'uf.office_id = o.id');

        if ($filters['city']) {
            $qb->where($qb->expr()->like('o.city', ':city'))
                ->setParameter('city', "%{$filters['city']}%");
        }

        if ($filters['service']) {
            $qb->where($qb->expr()->like('o.city', ':city'))
                ->setParameter('city', "%{$filters['city']}%");
        }
//
//        if ($filters['date_from']) {
//            $qb->where($qb->expr()->gte(''));
//        }
//
//        if ($filters['date_to']) {
//            $qb->where($qb->expr()->gte(''));
//        }

        $qb->groupBy('u.id', 'o.id', 's.id');

        $result = $qb->execute()
            ->fetchAllAssociative();

        dump($result);
        return $result;
    }
}
