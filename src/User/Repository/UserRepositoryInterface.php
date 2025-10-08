<?php

declare(strict_types=1);

namespace Namlier\TDD\User\Repository;

use Namlier\TDD\User\Entity\User;

interface UserRepositoryInterface
{
    public function get(string $email): User;

    public function save(User $user): void;
}
