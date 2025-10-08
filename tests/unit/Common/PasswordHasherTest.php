<?php

declare(strict_types=1);

namespace Common;

use Namlier\TDD\Common\PasswordHasher;
use PHPUnit\Framework\TestCase;

class PasswordHasherTest extends TestCase
{
    public function testDoesPasswordLookHashed(): void
    {
        $sut = new PasswordHasher();
        $hashedPassword = $sut->hash('123123q');

        self::assertNotEquals('123123q', $hashedPassword);

        self::assertTrue($sut->doesPasswordLookHashed($hashedPassword));

        self::assertTrue($sut->verify('123123q', $hashedPassword));

        self::assertFalse($sut->doesPasswordLookHashed('123123q'));
    }
}
