<?php

declare(strict_types=1);

namespace NowMe\Event;

final class PaymentWasRefunded
{
    public function __construct(private int $paymentId)
    {
    }

    public function paymentId(): int
    {
        return $this->paymentId;
    }
}
