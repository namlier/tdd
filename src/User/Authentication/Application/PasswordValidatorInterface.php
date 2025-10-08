<?php

declare(strict_types=1);

namespace Namlier\TDD\User\Authentication\Application;

interface PasswordValidatorInterface
{
    public function ensureValid(string $password): void;
}
