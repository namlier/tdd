<?php

namespace Tests\Integration\Sqlite;

use Namlier\UnitTesting\SQL\Insert;
use Namlier\UnitTesting\SQL\Select;
use Tests\Integration\BaseTestCase;
use Namlier\UnitTesting\Sqlite\DB;

class DBTest extends BaseTestCase
{
    public function testInsertAndSelectWork(): void
    {
        /** @var DB $db */
        $db = $this->getContainer()
            ->get(DB::class);

        $user = ['name' => 'Sasha', 'email' => 'namliers@gmail.com'];

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
