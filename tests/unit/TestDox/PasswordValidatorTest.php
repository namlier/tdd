<?php

declare(strict_types=1);

namespace TestDox;

use Namlier\UnitTesting\TestDox\PasswordValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class PasswordValidatorTest extends TestCase
{
    private const string SPECIAL_SYMBOLS = '!@#$%^&*()';

    /**
     * Array count is 8.
     */
    private const array GOOD_PASSWORD_CHARACTERS_EXAMPLE = [
        '1',
        '2',
        '3',
        '4',
        '5',
        'uppercase' => 'N',
        'lowercase' => 'n',
        'special_symbol' => '@'
    ];

    public function testIsNotValidWhenThereAreLessThan8Symbols(): void
    {
        $sut = new PasswordValidator();

        $goodPasswordArray = self::GOOD_PASSWORD_CHARACTERS_EXAMPLE;
        $badPasswordArray = array_slice($goodPasswordArray, 0, 7);

        if (count($badPasswordArray) >= 8) {
            $this->fail('It is important for the test to have less than 8 symbols in provided password');
        }

        $notEnoughCharactersPassword = implode($badPasswordArray);

        self::expectException(\Exception::class);
        self::expectExceptionMessage('Password should contain at least 8 symbols.');

        $sut->isValid($notEnoughCharactersPassword);
    }

    public function testIsNotValidWhenNoAnyUppercaseCharProvided(): void
    {
        $sut = new PasswordValidator();

        $goodPasswordArray = self::GOOD_PASSWORD_CHARACTERS_EXAMPLE;
        $badPasswordArray = array_filter($goodPasswordArray, fn ($value, $key) => $key !== 'uppercase', ARRAY_FILTER_USE_BOTH);
        array_push($badPasswordArray, 'n');

        $noUpperCasePassword = implode($badPasswordArray);

        self::expectException(\Exception::class);
        self::expectExceptionMessage('Password should contain at least one uppercase character.');

        $sut->isValid($noUpperCasePassword);
    }

    public function testIsNotValidWhenNoAnyLowercaseCharProvided(): void
    {
        $sut = new PasswordValidator();

        $goodPasswordArray = self::GOOD_PASSWORD_CHARACTERS_EXAMPLE;
        $badPasswordArray = array_filter($goodPasswordArray, fn ($value, $key) => $key !== 'lowercase', ARRAY_FILTER_USE_BOTH);
        array_push($badPasswordArray, 'N');

        $noLowerCasePassword = implode($badPasswordArray);

        self::expectException(\Exception::class);
        self::expectExceptionMessage('Password should contain at least one lowercase character.');

        $sut->isValid($noLowerCasePassword);
    }

    public function testIsNotValidWhenNoAnyNumberProvided(): void
    {
        $sut = new PasswordValidator();

        $goodPasswordArray = self::GOOD_PASSWORD_CHARACTERS_EXAMPLE;
        $badPasswordArray = array_slice($goodPasswordArray, 5);
        array_push($badPasswordArray, 'q', 'w', 'e', 'r', 't ');

        $noAnyNumberPassword = implode($badPasswordArray);

        self::expectException(\Exception::class);
        self::expectExceptionMessage('Password should contain at least one number.');

        $sut->isValid($noAnyNumberPassword);
    }

    public function testIsNotValidWhenNoAnySpecialSymbolProvided(): void
    {
        $sut = new PasswordValidator();

        $goodPasswordArray = self::GOOD_PASSWORD_CHARACTERS_EXAMPLE;
        $badPasswordArray = array_filter($goodPasswordArray, fn ($value, $key) => $key !== 'special_symbol', ARRAY_FILTER_USE_BOTH);
        array_push($badPasswordArray, 'N');

        $noAnySpecialSymbolPassword = implode($badPasswordArray);

        self::expectException(\Exception::class);
        self::expectExceptionMessage('Password should contain at least one special symbol from list "' . self::SPECIAL_SYMBOLS . '".');

        $sut->isValid($noAnySpecialSymbolPassword);
    }
}