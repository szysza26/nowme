<?php

declare(strict_types=1);

namespace NowMe\Controller\Api\Security\Model;

final class RegisterRequest
{
    public string $username;
    public string $email;
    public string $plainPassword;
    public string $firstName;
    public string $lastName;
}
