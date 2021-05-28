<?php

declare(strict_types=1);

namespace NowMe\Event;

final class ReservationWasCreated
{
    public function __construct(private int $reservationId)
    {
    }

    public function reservationId(): int
    {
        return $this->reservationId;
    }
}
