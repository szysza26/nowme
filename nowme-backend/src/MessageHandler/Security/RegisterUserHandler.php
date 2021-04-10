<?php

declare(strict_types=1);

namespace NowMe\MessageHandler\Security;

use NowMe\Entity\User;
use NowMe\Message\Security\RegisterUser;
use NowMe\Repository\UserRepository;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

final class RegisterUserHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private PasswordEncoderInterface $passwordEncoder
    ) {
    }

    public function __invoke(RegisterUser $message): void
    {
        $user = User::create(
            $message->username(),
            $message->email(),
            $this->passwordEncoder->encodePassword($message->password(), null)
        );

        $this->userRepository->add($user);
    }
}
