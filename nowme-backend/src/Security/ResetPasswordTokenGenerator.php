<?php

declare(strict_types=1);

namespace NowMe\Security;

final class ResetPasswordTokenGenerator
{
    public function generate(): string
    {
        return hash('sha512', \bin2hex(\random_bytes(40)));
    }
}
