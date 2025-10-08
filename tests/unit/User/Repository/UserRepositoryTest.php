<?php

declare(strict_types=1);

use Doctrine\Instantiator\Instantiator;
use Namlier\TDD\Infrastructure\User\Repository\UserRepository;
use Namlier\TDD\SQL\DB;
use PHPUnit\Framework\TestCase;

class UserRepositoryTest extends TestCase
{
    public function testGetReturnsUserWithID(): void
    {
        $db = $this->createStub(DB::class);
        $sut = new UserRepository($db, new Instantiator());
        $db->method('selectOne')
            ->willReturn(['id' => 1, 'email' => 'John', 'password' => 'password']);

        $user = $sut->get('johndoe@gmail.com');

        self::assertEquals(
            1,
            $user->getId(),
            'User repository should return users with Identifier'
        );
    }
}
