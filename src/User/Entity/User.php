<?php

declare(strict_types=1);

namespace Namlier\UnitTesting\User\Entity;

class User
{
    private readonly int $id;

    public function __construct(private readonly string $email, private readonly string $password) {}

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }
}
