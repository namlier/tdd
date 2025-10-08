<?php

declare(strict_types=1);

namespace Namlier\UnitTesting\User\Authentication\Application;

interface PasswordHasherInterface
{
    public function hash(string $plainPassword): string;

    public function verify(string $password, string $hash): bool;

    public function doesPasswordLookHashed(string $password): bool;
}
