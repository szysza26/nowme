<?php

declare(strict_types=1);

namespace NowMe\Query\Api\Repository;

use NowMe\Query\Api\Model\DictionarySpecialists;

interface SpecialistDictionaryRepository
{
    public function all(): DictionarySpecialists;
}
