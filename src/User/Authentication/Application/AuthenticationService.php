<?php

declare(strict_types=1);

namespace Namlier\TDD\User\Authentication\Application;

use Namlier\TDD\User\Entity\User;
use Namlier\TDD\User\Repository\UserRepository;

class AuthenticationService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly PasswordHasherInterface $passwordHasher
    ) {}

    public function register(string $email, string $password): void
    {
        $password = $this->passwordHasher->hash($password);
        $user = new User($email, $password);

        $this->userRepository->save($user);
    }
}
