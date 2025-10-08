<?php

declare(strict_types=1);

namespace Namlier\UnitTesting\User\Authentication\Application;

use Namlier\UnitTesting\User\Entity\User;
use Namlier\UnitTesting\User\Repository\UserRepository;

class AuthenticationService
{
    public function __construct(private readonly UserRepository $userRepository) {}

    public function register(string $email, string $password): void
    {
        $user = new User($email, $password);

        $this->userRepository->save($user);
    }
}
