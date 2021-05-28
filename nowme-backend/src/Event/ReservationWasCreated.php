<?php

declare(strict_types=1);

namespace NowMe\Event;

final class ReservationWasCreated
{
    public function __construct(private ?string $phoneNumber)
    {
    }

    public function phoneNumber(): ?string
    {
        return $this->phoneNumber;
    }
}
