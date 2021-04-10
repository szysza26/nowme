<?php

declare(strict_types=1);

namespace NowMe\MessageHandler\Security;

use NowMe\Message\Security\RegisterUser;
use NowMe\Model\User;
use NowMe\Security\Model\User as SecurityUser;
use NowMe\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;

final class RegisterUserHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private EncoderFactoryInterface $passwordEncoder
    ) {
    }

    public function __invoke(RegisterUser $message): void
    {
        $user = User::create(
            $message->username(),
            $message->email(),
            $this->passwordEncoder->getEncoder(SecurityUser::class)->encodePassword($message->password(), null),
            $message->firstName(),
            $message->lastName(),
        );

        $this->userRepository->add($user);
    }
}
