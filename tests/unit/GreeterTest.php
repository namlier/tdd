<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Namlier\UnitTesting\Greeter;

class GreeterTest extends TestCase
{
    public function testGreetWillReturnMessageWithProvidedGreetWord(): void
    {
        $sut = new Greeter();
        $result = $sut->greet('Sasha');

        self::assertEquals('Hello Sasha!', $result, '"Hello {{ greetWord }}!" should be returned if greetWord param provided.');
    }

    public function testGreetWillReturnDefaultMessageWhenNoGreetWordProvided(): void
    {
        $sut = new Greeter();
        $result = $sut->greet();

        self::assertEquals('Hello World!', $result, '"Hello world!" should be returned if no greetWord param provided.');
    }

    public function testGreetWillThrowExceptionWhenGreetWordGreaterThan16(): void
    {
        $sut = new Greeter();
        $stringOf17Letters = '1234567890abcdefg';

        if (!(mb_strlen($stringOf17Letters) > 16)) {
            $this->fail('String for test should have more than 16 letters.');
        }

        self::expectException(\Exception::class);
        self::expectExceptionMessage('Greet word is too long!');

        $sut->greet($stringOf17Letters);
    }

    public function testGreetWith16LengthGreetWordWorksCorrectly(): void
    {
        $sut = new Greeter();
        $stringOf16Letters = '1234567890abcdef';

        if (mb_strlen($stringOf16Letters) !== 16) {
            $this->fail('String for test should have exactly 16 letters.');
        }

        $result = $sut->greet($stringOf16Letters);

        self::assertEquals("Hello 1234567890abcdef!", $result);
    }
}