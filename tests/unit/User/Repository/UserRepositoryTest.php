<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Namlier\UnitTesting\User\Repository\UserRepository;
use Namlier\UnitTesting\SQL\DB;

class UserRepositoryTest extends TestCase
{
    public function testGetReturnsUserWithID(): void
    {
        $db = $this->createStub(DB::class);
        $sut = new UserRepository($db);
        $db->method('selectOne')
            ->willReturn(['id' => 'id1', 'email' => 'John', 'password' => 'password']);

        $user = $sut->get('johndoe@gmail.com');

        self::assertEquals(
            'id1',
            $user->getId(),
            'User repository should return users with Identifier'
        );
    }
}
