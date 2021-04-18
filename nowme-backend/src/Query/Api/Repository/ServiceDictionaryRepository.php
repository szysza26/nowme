<?php

declare(strict_types=1);

namespace NowMe\Query\Api\Repository;

use NowMe\Query\Api\Model\DictionaryServices;

interface ServiceDictionaryRepository
{
    public function all(): DictionaryServices;
}
