<?php

declare(strict_types=1);

namespace NowMe\MessageHandler\Security;

use NowMe\Message\Security\ResetPassword;
use NowMe\Repository\UserRepository;
use NowMe\Security\Model\User as SecurityUser;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

final class ResetPasswordHandler
{
    public function __construct(private EncoderFactoryInterface $encoderFactory, private UserRepository $users)
    {
    }

    public function __invoke(ResetPassword $message)
    {
        $this->users->getByResetPasswordToken($message->token())->resetPassword(
            $message->token(),
            $this->encoderFactory->getEncoder(SecurityUser::class)->encodePassword($message->plainPassword(), null),
        );
    }
}
