<?php

declare(strict_types=1);

namespace TestDox;

use Namlier\UnitTesting\TestDox\PasswordValidator;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\TestDox;
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

        $badPasswordArray = array_slice(self::GOOD_PASSWORD_CHARACTERS_EXAMPLE, 1, 7);
        $notEnoughCharactersPassword = implode($badPasswordArray);

        self::expectException(\Exception::class);
        self::expectExceptionMessage('Password should contain at least 8 symbols.');

        $sut->isValid($notEnoughCharactersPassword);
    }

    public function testIsNotValidWhenNoAnyUppercaseCharProvided(): void
    {
        $sut = new PasswordValidator();

        $noUpperCasePassword = $this->createPasswordWithoutAnyUppercaseChar();

        self::expectException(\Exception::class);
        self::expectExceptionMessage('Password should contain at least one uppercase character.');

        $sut->isValid($noUpperCasePassword);
    }

    public function testIsNotValidWhenNoAnyLowercaseCharProvided(): void
    {
        $sut = new PasswordValidator();

        $noLowerCasePassword = $this->createPasswordWithoutAnyLowercaseCharProvided();

        self::expectException(\Exception::class);
        self::expectExceptionMessage('Password should contain at least one lowercase character.');

        $sut->isValid($noLowerCasePassword);
    }

    public function testIsNotValidWhenAnyNumberProvided(): void
    {
        $sut = new PasswordValidator();

        $noAnyNumberPassword = $this->createPasswordWithoutAnyNumber();

        self::expectException(\Exception::class);
        self::expectExceptionMessage('Password should contain at least one number.');

        $sut->isValid($noAnyNumberPassword);
    }

    public function testIsNotValidWhenNoAnySpecialSymbolProvided(): void
    {
        $sut = new PasswordValidator();

        $noAnySpecialSymbolPassword = $this->createPasswordWithoutSpecialSymbol();

        self::expectException(\Exception::class);
        self::expectExceptionMessage('Password should contain at least one special symbol from list "' . self::SPECIAL_SYMBOLS . '".');

        $sut->isValid($noAnySpecialSymbolPassword);
    }

    #[DataProvider('goodPasswordWithSpecialSymbol')]
    #[TestDox('It should be valid $_dataName')] // $_dataName is a name of the data set
    public function testAnyOfSpecialSymbolLeadsToValidPassword(string $specialSymbol, string $usedSpecialSymbol): void
    {
        $sut = new PasswordValidator();

        $passwordArray = array_replace(
            self::GOOD_PASSWORD_CHARACTERS_EXAMPLE,
            ['special_symbol' => $specialSymbol]
        );
        $password = implode($passwordArray);

        self::assertTrue(
            $sut->isValid($password),
            'It should be valid if this special symbol is used and all of the others conditions satisfied.'
        );
    }

    public static function goodPasswordWithSpecialSymbol(): \Generator
    {
        $specialSymbols = str_split(self::SPECIAL_SYMBOLS);

        $i = 1;

        foreach ($specialSymbols as $specialSymbol) {
            $passwordArray = array_replace(
                self::GOOD_PASSWORD_CHARACTERS_EXAMPLE,
                ['special_symbol' => $specialSymbol]
            );

            yield 'with symbol "' . $specialSymbol . '"' => [implode($passwordArray), $specialSymbol];
            $i++;
        }
    }

    private function createPasswordWithoutAnyUppercaseChar(): string
    {
        $withoutUppercasePasswordArray = array_replace(self::GOOD_PASSWORD_CHARACTERS_EXAMPLE, ['uppercase' => 'n']);

        return implode($withoutUppercasePasswordArray);
    }

    private function createPasswordWithoutAnyLowercaseCharProvided(): string
    {
        $withoutLowercasePasswordArray = array_replace(self::GOOD_PASSWORD_CHARACTERS_EXAMPLE, ['lowercase' => 'N']);

        return implode($withoutLowercasePasswordArray);
    }

    private function createPasswordWithoutAnyNumber(): string
    {
        $withoutNumberPasswordArray = array_slice(self::GOOD_PASSWORD_CHARACTERS_EXAMPLE, 5);
        array_push($withoutNumberPasswordArray, 'q', 'w', 'e', 'r', 't ');

        return implode($withoutNumberPasswordArray);
    }

    private function createPasswordWithoutSpecialSymbol(): string
    {
        $withoutSpecialSymbolPasswordArray = array_replace(self::GOOD_PASSWORD_CHARACTERS_EXAMPLE, ['special_symbol' => 'N']);

        return implode($withoutSpecialSymbolPasswordArray);
    }
}
