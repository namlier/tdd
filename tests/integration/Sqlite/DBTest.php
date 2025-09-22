<?php

namespace Tests\Integration\Sqlite;

use Tests\Integration\BaseTestCase;
use Namlier\UnitTesting\Sqlite\DB;

class DBTest extends BaseTestCase
{
    // TODO: тест depends, можна просто сервіс викликати, і QueryRepository (query? щоб потім якось в дептрак добавити
    public function testInsert(): void
    {
        /** @var DB $db */
        $db = $this->getContainer()
            ->get(DB::class);

        $db->insert('users', ['name' => 'Sasha', 'email' => 'namliers@gmail.com']);
        $array = $db->queryAll('users');
    }
}
