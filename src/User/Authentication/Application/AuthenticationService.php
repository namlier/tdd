<?php

declare(strict_types=1);

namespace Namlier\TDD\User\Authentication\Application;

use Namlier\TDD\User\Repository\UserRepositoryInterface;
use Namlier\TDD\User\Entity\User;

class AuthenticationService
{
    public function __construct(
        private readonly UserRepositoryInterface $userRepository,
        private readonly PasswordHasherInterface $passwordHasher,
        private readonly PasswordValidatorInterface $passwordValidator,
    ) {}

    public function register(string $email, string $password): void
    {
        $this->passwordValidator->ensureValid($password);
        $password = $this->passwordHasher->hash($password);
        $user = new User($email, $password);

        $this->userRepository->save($user);
    }
}
