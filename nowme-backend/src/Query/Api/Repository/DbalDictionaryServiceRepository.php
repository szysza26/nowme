<?php

declare(strict_types=1);

namespace NowMe\Query\Api\Repository;

use Doctrine\DBAL\Connection;
use NowMe\Query\Api\Model\DictionaryService;
use NowMe\Query\Api\Model\DictionaryServices;

final class DbalDictionaryServiceRepository implements ServiceDictionaryRepository
{
    public function __construct(private Connection $connection)
    {
    }

    public function all(): DictionaryServices
    {
        $qb = $this->connection->createQueryBuilder();

        $results = $qb->select(['sd.id', 'sd.name'])
            ->from('service_dictionary', 'sd')
            ->execute()
            ->fetchAllAssociative();

        return new DictionaryServices(
            ...array_map(
                   static function (array $dictionaryService) {
                       return new DictionaryService((int)$dictionaryService['id'], $dictionaryService['name']);
                   },
                   $results
               )
        );
    }
}
