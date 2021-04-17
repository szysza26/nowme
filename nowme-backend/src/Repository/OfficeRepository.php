<?php

declare(strict_types=1);

namespace NowMe\Repository;

use NowMe\Entity\Office;

interface OfficeRepository
{
    public function add(Office $office): void;

    public function edit(Office $office): void;

    public function delete(Office $office): void;

    public function get(int $id) : Office;

    public function all(): array;

    public function allById(array $offices): array;
}
