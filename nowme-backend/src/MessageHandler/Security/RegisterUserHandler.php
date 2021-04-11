<?php

declare(strict_types=1);

namespace NowMe\MessageHandler\Security;

use NowMe\Event\UserWasCreated;
use NowMe\Message\Security\RegisterUser;
use NowMe\Model\User;
use NowMe\Security\Model\User as SecurityUser;
use NowMe\Repository\UserRepository;
use NowMe\Security\Sha512TokenGenerator;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Contracts\EventDispatcher\EventDispatcherInterface;

final class RegisterUserHandler
{
    public function __construct(
        private UserRepository $userRepository,
        private EncoderFactoryInterface $passwordEncoder,
        private EventDispatcherInterface $eventDispatcher,
        private Sha512TokenGenerator $generator
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

        $token = $this->generator->generate();
        $this->userRepository->add($user);

        $this->eventDispatcher->dispatch(
            new UserWasCreated($message->username(), $message->email(), $token)
        );
    }
}
