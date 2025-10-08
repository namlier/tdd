<?php

declare(strict_types=1);

namespace Entity;

use Namlier\TDD\User\Entity\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    public function testCreateNewUserGetsDefaultRole(): void
    {
        $sut = new User('johndoe@gmail.com', '123123q');

        self::assertEquals('ROLE_USER', $sut->getRole(), 'User should get default role during creation.');
    }
}
