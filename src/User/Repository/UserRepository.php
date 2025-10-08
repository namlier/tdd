<?php

declare(strict_types=1);

namespace Namlier\UnitTesting\User\Repository;

use Namlier\UnitTesting\SQL\DB;
use Namlier\UnitTesting\SQL\Insert;
use Namlier\UnitTesting\SQL\Select;
use Namlier\UnitTesting\User\Entity\User;

class UserRepository
{
    public function __construct(
        private readonly DB $db
    ) {

    }

    public function get(string $email): User
    {
        $select = new Select();
        $select->from('users');
        $select->fields('*');
        $select->where(['email' => $email]);
        $user = $this->db->selectOne($select);

        return new User($user['email'], $user['password']);
    }

    public function save(User $user): void
    {
        $insert = new Insert();
        $insert->into('users');
        $insert->values(['email' => $user->getEmail(), 'password' => $user->getPassword()]);

        $this->db->insert($insert);
    }
}
