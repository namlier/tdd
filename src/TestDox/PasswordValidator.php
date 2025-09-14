<?php

declare(strict_types=1);

namespace Namlier\UnitTesting\TestDox;

class PasswordValidator
{
    public function isValid(string $password): bool
    {
        return mb_strlen($password) >= 8;
    }
}