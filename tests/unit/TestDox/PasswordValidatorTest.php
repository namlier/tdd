<?php

declare(strict_types=1);

namespace TestDox;

use Namlier\UnitTesting\TestDox\PasswordValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PasswordValidatorTest extends TestCase
{
    #[DataProvider('minimum8SymbolsProvider')]
    public function testIsValidWhenMinimum8Symbols($password, $expected, $messageOnFail): void
    {
        $sut = new PasswordValidator();

        $result = $sut->isValid($password);

        $this->assertEquals($expected, $result, $messageOnFail);
    }

    public static function minimum8SymbolsProvider(): array
    {
        return [
            '7 symbols' => ['1234567', false, 'It should be not valid when there is less than 8 symbols'],
            '0 symbols' => ['', false, 'It should be not valid when there are no symbols'],
            '8 symbols' => ['12345678', true, 'It should be valid when there are 8 symbols'],
            '9 symbols' => ['123456789', true, 'It should be valid when there are more than 8 symbols'],
            '16 symbols' => ['1234567890123456', true, 'It should be valid when there are more than 8 symbols'],
        ];
    }
}