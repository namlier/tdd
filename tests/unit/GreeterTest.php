<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Namlier\UnitTesting\Greeter;

class GreeterTest extends TestCase
{
    public function testGreetWordWillBeUsedInGreetMessage(): void
    {
        $sut = new Greeter();
        $result = $sut->greet('Sasha');

        self::assertEquals('Hello Sasha!', $result, '"Hello {{ greetWord }}!" should be returned if greetWord param provided.');
    }

    public function testWorldStringWillBeUsedInGreetMessageIfNoWordProvided(): void
    {
        $sut = new Greeter();
        $result = $sut->greet();

        self::assertEquals('Hello World!', $result, '"Hello world!" should be returned if no greetWord param provided.');
    }

    public function testExceptionWillBeThrownWhenGreetWordGreaterThan16(): void
    {
        $sut = new Greeter();
        $stringOf17Letters = '1234567890abcdefg';

        if (mb_strlen($stringOf17Letters) < 17) {
            self::fail('String for test should have at least 17 letters.');
        }

        self::expectException(\Exception::class);
        self::expectExceptionMessage('Greet word is too long!');

        $result = $sut->greet($stringOf17Letters);
    }
}