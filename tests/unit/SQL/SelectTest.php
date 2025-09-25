<?php

declare(strict_types=1);

namespace SQL;

use Namlier\UnitTesting\SQL\Select;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class SelectTest extends TestCase
{
    public function testFieldsIsMandatoryPartOfStatement(): void
    {
        $sut = new Select();

        self::expectException(\Exception::class);
        self::expectExceptionMessage('Fields is a mandatory part of a statement.');

        $sut->getStatement();

    }

    public function testFromIsMandatoryPartOfStatement(): void
    {
        $sut = new Select();
        $sut->fields('*');

        self::expectException(\Exception::class);
        self::expectExceptionMessage('From is a mandatory part of a statement.');

        $sut->getStatement();
    }

    public function testGetStatementWillWorkWithFromAndFieldsParts(): void
    {
        $sut = new Select();
        $sut->fields('*');
        $sut->from('users');

        $result = $sut->getStatement();

        self::assertEquals('SELECT * FROM `users`;', $result);
    }

    #[DataProvider('fieldsTestProvider')]
    public function testFieldsMethodInvocationPatterns(string|array $fields, string $from, string $expectedStatement, string $messageOnFail): void
    {
        $sut = new Select();
        $sut->fields($fields);
        $sut->from($from);

        $result = $sut->getStatement();

        self::assertEquals($expectedStatement, $result, $messageOnFail);
    }

    public function testWhereClause(): void
    {
        $sut = new Select();
        $sut->fields('*');
        $sut->from('users');
        $sut->where(['name' => 'Sasha', 'email' => 'namliers@gmail.com']);

        $resultStatement = $sut->getStatement();
        $resultBoundedValues = $sut->getBoundedValues();

        self::assertEquals('SELECT * FROM `users` WHERE `name` = :name AND `email` = :email;', $resultStatement);
        self::assertEquals([':name' => 'Sasha', ':email' => 'namliers@gmail.com'], $resultBoundedValues);
    }

    public static function fieldsTestProvider(): array
    {
        return [
            ['*', 'users', 'SELECT * FROM `users`;', 'Fields should work with provided asterisk "*".'],
            [['id', 'name', 'email'], 'users', "SELECT `id`, `name`, `email` FROM `users`;", 'Fields should work with provided array.'],
            ['id,name, email', 'users', "SELECT `id`, `name`, `email` FROM `users`;", 'Fields should work with listed fields as string.'],
            ['`id`, `name`,`email`', 'users', "SELECT `id`, `name`, `email` FROM `users`;", 'Fields should work with listed fields wrapped in backticks as string.']
        ];
    }
}
