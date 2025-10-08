<?php

declare(strict_types=1);

namespace Namlier\UnitTesting\User\Repository;

use Namlier\UnitTesting\SQL\DB;
use Namlier\UnitTesting\SQL\Insert;
use Namlier\UnitTesting\SQL\Select;
use Namlier\UnitTesting\User\Entity\User;
use Doctrine\Instantiator\Instantiator;
use ReflectionClass;

class UserRepository
{
    public function __construct(
        private readonly DB $db,
        private readonly Instantiator $instantiator
    ) {}

    public function get(string $email): User
    {
        $select = new Select();
        $select->from('users');
        $select->fields('*');
        $select->where(['email' => $email]);
        $user = $this->db->selectOne($select);

        return $this->hydrateUser($user['id'], $user['email'], $user['password']);
    }

    public function save(User $user): void
    {
        $insert = new Insert();
        $insert->into('users');
        $insert->values(['email' => $user->getEmail(), 'password' => $user->getPassword()]);

        $this->db->insert($insert);
    }

    private function hydrateUser(int $id, string $email, string $password): User
    {
        $user = $this->instantiator->instantiate(User::class);

        $reflection = new ReflectionClass($user);

        $property = $reflection->getProperty('id');
        $property->setValue($user, $id);

        $property = $reflection->getProperty('email');
        $property->setValue($user, $email);

        $property = $reflection->getProperty('password');
        $property->setValue($user, $password);

        return $user;
    }
}
