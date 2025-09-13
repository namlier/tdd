<?php

declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\DataProvider;
use Namlier\UnitTesting\Greeter;

class GreeterTest extends TestCase
{
    public function testGreetWordWillBeUsedInGreetMessage(): void
    {
        $sut = new Greeter();
        $result = $sut->greet('Sasha');

        $this->assertEquals('Hello Sasha!', $result, '"Hello {{ greetWord }}!" should be returned if greetWord param provided.');
    }

    public function testWorldStringWillBeUsedInGreetMessageIfNoWordProvided(): void
    {
        $sut = new Greeter();
        $result = $sut->greet();

        $this->assertEquals('Hello World!', $result, '"Hello world!" should be returned if no greetWord param provided.');
    }
}