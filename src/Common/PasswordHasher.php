<?php

declare(strict_types=1);

namespace Namlier\TDD\Common;

use Namlier\TDD\User\Authentication\Application\PasswordHasherInterface;

class PasswordHasher implements PasswordHasherInterface
{
    public function hash(string $plainPassword): string
    {
        return password_hash($plainPassword, PASSWORD_BCRYPT, ['cost' => 13]);
    }

    public function verify(string $password, string $hash): bool
    {
        return password_verify($password, $hash);
    }

    public function doesPasswordLookHashed(string $password): bool
    {
        $result = password_get_info($password);

        if ($result['algo'] === PASSWORD_BCRYPT && $result['options'] === ['cost' => 13]) {
            return true;
        }

        return false;
    }
}
