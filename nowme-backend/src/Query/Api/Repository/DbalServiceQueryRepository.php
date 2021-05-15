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
                's.name_id',
                's.id as service_id',
                'o.id as office_id'
            ]
        )
            ->from('availability', 'a')
            ->leftJoin('a', 'user', 'u', 'a.specjalist_id = u.id')
            ->leftJoin('u', 'user_office', 'uf', 'u.id = uf.user_id')
            ->leftJoin('uf', 'office', 'o', 'uf.office_id = o.id')
            ->leftJoin('u', 'service', 's', 'a.specjalist_id = s.specialist_id')
            ->innerJoin('s', 'service_dictionary', 'sd', 's.name_id = sd.id');

        if ($filters['service']) {
            $qb->andWhere($qb->expr()->eq('sd.id', ':service'))
                ->setParameter('service', $filters['service']);
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

    public function details(array $data): array
    {
        $qb = $this->connection->createQueryBuilder();

        $qb->select(
            [
                'a.date',
                'a.hour_from',
                'a.hour_to',
            ]
        )
            ->from('availability', 'a')
            ->leftJoin('a', 'user', 'u', 'a.specjalist_id = u.id')
            ->leftJoin('u', 'user_office', 'uf', 'u.id = uf.user_id')
            ->leftJoin('uf', 'office', 'o', 'uf.office_id = o.id')
            ->leftJoin('u', 'service', 's', 'a.specjalist_id = s.specialist_id')
            ->innerJoin('s', 'service_dictionary', 'sd', 's.name_id = sd.id');

        if ($data['specialist']) {
            $qb->andWhere($qb->expr()->eq('u.id', ':specialist'))
                ->setParameter('specialist', $data['specialist']);
        }

        if ($data['service']) {
            $qb->andWhere($qb->expr()->eq('sd.id', ':service'))
                ->setParameter('service', $data['service']);
        }

        if ($data['office']) {
            $qb->andWhere($qb->expr()->eq('o.id', ':office'))
                ->setParameter('office', $data['office']);
        }

        if ($data['date_from']) {
            $qb->andWhere($qb->expr()->gte('a.date', ':date_from'))
                ->setParameter('date_from', $data['date_from']);
        }

        if ($data['date_to']) {
            $qb->andWhere($qb->expr()->lte('a.date', ':date_to'))
                ->setParameter('date_to', $data['date_to']);
        }

        $qb->groupBy('u.id', 'o.id', 's.id', 'a.id');

        dump($qb->getSQL());

        $result = $qb->execute()
            ->fetchAllAssociative();

        return $result;
    }
}
