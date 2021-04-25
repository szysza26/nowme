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
            ->from('availability', 'a')
            ->leftJoin('a', 'user', 'u', 'a.specjalist_id = u.id')
            ->leftJoin('u', 'user_office', 'uf', 'u.id = uf.user_id')
            ->leftJoin('uf', 'office', 'o', 'uf.office_id = o.id')
            ->leftJoin('u', 'service', 's', 'a.specjalist_id = s.specialist_id');

        if ($filters['service']) {
            $qb->where($qb->expr()->like('s.id', ':service'))
                ->setParameter('service', "%{$filters['service']}%");
        }

        if ($filters['city']) {
            $qb->andWhere($qb->expr()->like('o.city', ':city'))
                ->setParameter('city', "%{$filters['city']}%");
        }

        if ($filters['date_from']) {
            $qb->andWhere($qb->expr()->gte('a.date', ':date_from'))
                ->setParameter('date_from', $filters['date_from']);
        }

        if ($filters['date_to']) {
            $qb->andWhere($qb->expr()->lte('a.date', ':date_to'))
                ->setParameter('date_to', $filters['date_to']);
        }

        $qb->groupBy('u.id', 'o.id', 's.id');

        $result = $qb->execute()
            ->fetchAllAssociative();

        return $result;
    }
}
