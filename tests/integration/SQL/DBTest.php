<?php

namespace Tests\Integration\SQL;

use Namlier\TDD\SQL\DB;
use Namlier\TDD\SQL\Insert;
use Namlier\TDD\SQL\Select;
use Tests\Integration\BaseTestCase;

class DBTest extends BaseTestCase
{
    public function testInsertAndSelectWork(): void
    {
        /** @var DB $db */
        $db = $this->getContainer()
            ->get(DB::class);

        $user = ['email' => 'johndoe@gmail.com', 'password' => '123123q'];

        $insert = new Insert();
        $insert->into('users');
        $insert->values($user);

        $db->insert($insert);

        $insertedId = $db->lastInsertRowID();

        $select = new Select();
        $select->from('users');
        $select->fields('*');
        $select->where(['id' => $insertedId]);

        $actualUser = $db->selectOne($select);
        $expectedUser = $user;

        foreach ($expectedUser as $key => $value) {
            self::assertArrayHasKey($key, $actualUser);
            self::assertEquals($value, $actualUser[$key]);
        }
    }
}
