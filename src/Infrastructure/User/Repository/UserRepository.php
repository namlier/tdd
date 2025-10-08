<?php

declare(strict_types=1);

namespace Namlier\TDD\Infrastructure\User\Repository;

use Doctrine\Instantiator\Instantiator;
use Namlier\TDD\SQL\DB;
use Namlier\TDD\SQL\Insert;
use Namlier\TDD\SQL\Select;
use Namlier\TDD\User\Entity\User;
use Namlier\TDD\User\Repository\UserRepositoryInterface;
use ReflectionProperty;

class UserRepository implements UserRepositoryInterface
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

        $this->hydrateProperty($user, 'id', $id);
        $this->hydrateProperty($user, 'email', $email);
        $this->hydrateProperty($user, 'password', $password);

        return $user;
    }

    private function hydrateProperty(User $user, string $property, mixed $value): void
    {
        $property = new ReflectionProperty($user, $property);
        $property->setValue($user, $value);
    }
}
