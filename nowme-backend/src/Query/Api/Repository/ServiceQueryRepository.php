<?php

declare(strict_types=1);

namespace NowMe\Query\Api\Repository;

interface ServiceQueryRepository
{
    public function findByFilter(array $filters): array;

    public function details(array $data): array;
}
