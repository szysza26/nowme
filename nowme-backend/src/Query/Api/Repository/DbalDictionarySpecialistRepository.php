<?php

declare(strict_types=1);

namespace NowMe\Query\Api\Repository;

use Doctrine\DBAL\Connection;
use NowMe\Query\Api\Model\DictionarySpecialist;
use NowMe\Query\Api\Model\DictionarySpecialists;

final class DbalDictionarySpecialistRepository implements SpecialistDictionaryRepository
{
    public function __construct(private Connection $connection)
    {
    }

    public function all(): DictionarySpecialists
    {
        $qb = $this->connection->createQueryBuilder();

        $results = $qb->select(['sd.id', 'sd.name'])
            ->from('specialist_directory', 'sd')
            ->execute()
            ->fetchAllAssociative();

        return new DictionarySpecialists(
            ...array_map(
                   static function (array $dictionarySpecialist) {
                       return new DictionarySpecialist((int)$dictionarySpecialist['id'], $dictionarySpecialist['name']);
                   },
                   $results
               )
        );
    }
}
