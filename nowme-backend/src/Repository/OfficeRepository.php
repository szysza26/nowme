<?php

declare(strict_types=1);

namespace NowMe\Repository;

use NowMe\Entity\Office;

interface OfficeRepository
{
    public function add(Office $office): void;

    public function getByName(string $name): Office;
}
