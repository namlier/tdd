<?php

declare(strict_types=1);

namespace Namlier\TDD\User\Entity;

class User
{
    private const string DEFAULT_ROLE = 'ROLE_USER';

    private readonly int $id;

    private readonly string $role;

    public function __construct(private readonly string $email, private readonly string $password)
    {
        $this->role = self::DEFAULT_ROLE;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getRole(): string
    {
        return $this->role;
    }
}
