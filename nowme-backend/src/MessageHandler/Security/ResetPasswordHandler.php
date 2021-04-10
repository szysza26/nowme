<?php

declare(strict_types=1);

namespace NowMe\MessageHandler\Security;

use NowMe\Message\Security\ResetPassword;
use NowMe\Security\Model\User;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

final class ResetPasswordHandler
{
    public function __construct(private $users, private EncoderFactoryInterface $encoderFactory)
    {
    }

    public function __invoke(ResetPassword $message)
    {
        $this->users->getByResetPasswordToken($message->token())->resetPassword(
            $message->token(),
            $this->encoderFactory->getEncoder(User::class)->encodePassword($message->plainPassword(), null),
            $this->resetPasswordTokenTtl
        );
    }
}
